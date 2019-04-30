<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\AdvsStat;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\BannersStat;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\SettingsQuery;
use Yandex\SiteSearchPinger\SiteSearchPinger;
use Yandex\SiteSearchPinger\Exception\SiteSearchPingerException;
use Yandex\Common\Exception\YandexException;

class CronCommand extends ContainerAwareCommand
{

    # Ежедневное Cron-задание
    protected function configure()
    {
        $this
            ->setName('cron:daily')
            ->setDescription('Daily Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $top_panel = array();
        $top_panel['settings'] = SettingsQuery::create()->findOne();
        
        # Обновление статистики и обнуление счетчика "Просмотров сегодня"
        $advs = AdvsQuery::create()->find();
        foreach ( $advs as $adv ) {
          $adv_stat = new AdvsStat();
          $adv_stat->setAdvId($adv->getId());
          $adv_stat->setShows($adv->getCntToday());
          $adv_stat->setClicks($adv->getCntTelToday());
          $adv_stat->save();
          $adv->setCntToday(0);
          $adv->setCntTelToday(0);
          $adv->save();
        }
		
        # Обновление статистики рекламных баннеров
        $banners = BannersQuery::create()->find();
        foreach ( $banners as $banner ) {
          $banner_stat = new BannersStat();
          $banner_stat->setBannerId($banner->getId());
          $banner_stat->setResidue($banner->getCnt());
          $banner_stat->setShows($banner->getShowToday());
          $banner_stat->setClicks($banner->getClickToday());
          $banner_stat->save();
          $banner->setShowToday(0);
          $banner->setClickToday(0);
          $banner->save();
        }
        
        # Установка пакета Бесплатно всем у кого закончилось действие других пакетов
        $packets = AdvPacketsQuery::create()          
          ->filterByUseBefore(array("max" => strtotime( date("Y-m-d H:i:s")  )))
          ->find();
        foreach ($packets as $packet) {
          $packet->setPacketId(3);
          $packet->setPaid(true);          
          $packet->save();
        }
		
        # Отправка сообщения тем, кто не оплатил пакет в течении суток
        $packets = AdvPacketsQuery::create()          
          ->filterByDate(array("max" => strtotime( "-1 days", strtotime( date("Y-m-d H:i:s") ) )))
          ->filterByPaid(false)
          ->find();
        foreach ($packets as $packet) {
          $adv = AdvsQuery::create()->findOneById($packet->getAdvId());
          if ($adv) {
            $adv_user = UserQuery::create()->findOneById($adv->getUserId());
            # Отсылаем сообщение пользователю.
            $subject = 'Ваше объявление на '.$top_panel['settings']->getName().': Оплата пакета услуг';
            $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
            $to = $adv_user->getEmail();
            $body = $this->getContainer()->get('templating')->render(
                'AdminAdminBundle:Advs:paid.html.twig',
                array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'adv' => $adv, 'packet' => $packet)
            );
            $this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
            # увеличиваем счетчик кол-ва отправленных писем
            $email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
            $adv_user->setEmailSendCnt($email_cnt+1);
            $adv_user->save();
          }          
        }
        
        # Установка пакета Бесплатно тем, кто не оплатил пакет в течении 2 суток
        $packets = AdvPacketsQuery::create()          
          ->filterByDate(array("max" => strtotime( "-2 days", strtotime( date("Y-m-d H:i:s") ) )))
          ->filterByPaid(false)
          ->find();
        foreach ($packets as $packet) {
          $packet->setPacketId(3);
          $packet->setPaid(true);          
          $packet->save();
        }
        
        # Удаление изображений не присвоенных объявлениям с давностью загрузки более 1 дня
        $images = AdvImagesQuery::create()
          ->filterByAdvId(NULL)
          ->filterByUploadDate(array("max" => strtotime( "-1 days", strtotime( date("Y-m-d H:i:s") ) )))
          ->find();
        $dir = 'images/a/images';
        foreach ( $images as $image ) {
          $Filename = $image->getPath();          
          $fs = new Filesystem();
          try {              
            $fs->remove( $dir.'/'.$Filename );
          } catch (IOExceptionInterface $e) {
            $output->writeln('Не удалось удалить "'.$dir.'/'.$Filename.'"');
          }
          $image->delete();
        }
		
        # Удаление изображений не найденных в БД
        $advs_images = AdvImagesQuery::create()->find();
        $images = array();
        foreach ($advs_images as $advs_image) {
          $images[] = $advs_image->getPath();
          $images[] = $advs_image->getMediumThumb();
          $images[] = $advs_image->getThumb();
        }
        $output->writeln(count($images));
        
        $dir = '/var/www/'.mb_strtolower($top_panel['settings']->getName()).'/web/images/a/images/';
        $files = scandir($dir);
        $output->writeln(count($files));
        foreach($files as $file) {			
          if (!in_array($file, $images) && $file!='.' && $file!='..') {
            $fs = new Filesystem();
              try {              
              $fs->remove( $dir.$file );
              } catch (IOExceptionInterface $e) {
              $output->writeln('Не удалось удалить '.$file);
              }				
          }
        }
            
        # Пинг Яндекса	
        /*
        $pinger = new SiteSearchPinger();
        $pinger->key = "ec0e29030513fc8f2cb6e151f6d5b7fc6b335d53";
        $pinger->login = "clasoru";
        $pinger->searchId = "2225272";
          
        $advs = AdvsQuery::create()
          ->filterByYandexPing(0)		  
          ->find();
          
        $url = array();
        foreach ($advs as $adv) {			
          $url[] = "https://claso.ru/russia/".$adv->getId();
          $adv->setYandexPing(1);
          $adv->save();
        }
        try {
          $added = $pinger->ping($url);
        }  catch (SiteSearchPingerException $e) {
          echo "Site Search Pinger Exception<br/>";
          echo nl2br($e->getMessage());
        } catch (YandexException $e) {
          echo "Yandex Library Exception<br/>";
          echo nl2br($e->getMessage());
        } catch (\Exception $e) {
          echo get_class($e) . "<br/>";
          echo nl2br($e->getMessage());
        }

        if (sizeof($pinger->invalidUrls)) {
           echo "Invalid Urls:"."<br/>";
           foreach ($pinger->invalidUrls as $url => $reason) {
            echo $url ." - ".$reason."<br/>";
           }
        }
        */
        
        // Скрипты к себе
        $dir = '/var/www/'.mb_strtolower($top_panel['settings']->getName()).'/web/js';        
        $this->downloadJs('https://mc.yandex.ru/metrika/watch.js', $dir . '/watch.js');
        $this->downloadJs('https://www.google-analytics.com/analytics.js', $dir . '/analytics.js'); 
		
        $output->writeln('ok');
    }	
    
    function downloadJs($file_url, $save_to)
    {
        $content = file_get_contents($file_url);
        file_put_contents($save_to, $content);
    }   
	
}
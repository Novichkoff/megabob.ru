<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\UserAccountQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\SettingsQuery;
use Admin\AdminBundle\Controller\YandexXML;
use Yandex\SiteSearchPinger\SiteSearchPinger;
use Yandex\SiteSearchPinger\Exception\SiteSearchPingerException;
use Yandex\Common\Exception\YandexException;
use Admin\AdminBundle\Controller\Image;

class WorkCommand extends ContainerAwareCommand
{

    # Рабочее Cron-задание
    protected function configure()
    {
        $this
            ->setName('cron:work')
            ->setDescription('Work Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $top_panel = array();
        $top_panel['settings'] = SettingsQuery::create()->findOne();
      
        # проверяем адрес сайта в объявлениях    
        
        /*
        $regions = AreasQuery::create()->find();
        foreach ($regions as $region) {          
          var_dump($region->getAlias());
          $region->setAlias(str_replace('_', '-', $region->getAlias()));
          //$region->save();
        }
        
        
        $advs = AdvsQuery::create()        
                ->where('site IS NOT NULL')
                ->find();
                
        foreach ( $advs as $adv ) {                  
          $adv_url = $this->check_url($adv->getSite());
          var_dump($adv->getSite());
          if (!$adv_url) {            
            $adv->setSite(null);
            $adv->save();
          }          
        } 
        */
        
        /*
        $users = UserQuery::create()          
          ->find();
        foreach ($users as $user) {
          if (@$user->getId()) {
            $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());
            if (@$user->account && $user->account->getBonus()) {
              $user->account->setBalance($user->account->getBalance() + $user->account->getBonus());
              $user->account->setBonus(0);
              $user->account->save();
            }
          
            $output->writeln($user->getRealname());
          }
          
        }
        */
        
        /*
        $users = UserQuery::create()
          ->orderByPhoto('DESC')
          ->find();
        foreach ($users as $user) {
          if ($user->getPhoto()) {
            $Filename = uniqid();
            if (@$Filename) {
              $dir = '/var/www/claso.ru/web/images/users/photos';							
              $image_new = new Image($user->getPhoto());
              $image_new->thumbnail_full(50, 50);
              $image_new->save($dir . '/' . $Filename . '.png');
              unset($image_new);
            }
            $user->setPhoto($Filename.'.png');
            $user->save();
          }
          //$output->writeln($user->getPhoto());
        }
        */
        
        // Скрипты к себе
        /*
        $dir = '/var/www/claso.ru/web/js';        
        $this->downloadJs('https://mc.yandex.ru/metrika/watch.js', $dir . '/watch.js');
        $this->downloadJs('http://www.google-analytics.com/analytics.js', $dir . '/analytics.js'); 
        $this->downloadJs('https://www.gstatic.com/charts/loader.js', $dir . '/google_loader.js'); 
        */
        /*
        # Первую букву Заглавной      
        $advs = AdvsQuery::create()        
                ->find();
                
        foreach ( $advs as $adv ) {                  
          $adv->setDescription($this->my_ucfirst($adv->getDescription()));
          $adv->save();
        } 
        */
        /*$packet = AdvPacketsQuery::create()->findOneById(15691);
        //foreach ($packets as $packet) {
          $adv = AdvsQuery::create()->findOneById($packet->getAdvId());
          if ($adv) {
            $adv_user = UserQuery::create()->findOneById($adv->getUserId());
            # Отсылаем сообщение пользователю.
            $subject = 'Ваше объявление на Claso: оплата пакета';
            $from = 'Claso <no-reply@claso.ru>';
            $to = $adv_user->getEmail();
            $body = $this->getContainer()->get('templating')->render(
                'AdminAdminBundle:Advs:paid.html.twig',
                array('email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'adv' => $adv, 'packet' => $packet)
            );
            $output->writeln($to);
            $this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
            # увеличиваем счетчик кол-ва отправленных писем
            //$email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
            //$adv_user->setEmailSendCnt($email_cnt+1);
            //$adv_user->save();
          }          
        //}*/
		
		/*
		$categories = AdCategoriesQuery::create()->filterByParentId(null)->find();
		foreach ($categories as $category) {
			$title = $this->translate($category->getName());
			$title_url = $this->str2url($title);
			$category->setName($title);
			$category->setAlias($title_url);
			if ($category->getPagetitle()) {
				$category->setPagetitle($this->translate($category->getPagetitle()));
			} else {
				$category->setPagetitle($title);
			}
			if ($category->getCatchPhrase()) {
				$category->setCatchPhrase($this->translate($category->getCatchPhrase()));
			}
			if ($category->getText()) {
				$category->setText($this->translate($category->getText()));
			}
			if ($category->getDirectTitle()) {
				$category->setDirectTitle($this->translate($category->getDirectTitle()));
			}
			$output->writeln($title);
			$output->writeln($title_url);
			$category->save();			
		}*/
    
          $user_advs = AdvsQuery::create()->limit(5)->find();
          $adv_user = UserQuery::create()->findOneById( 16599 );
          # Отсылаем сообщение пользователю, что объявление будет удалено.
          $subject = 'Ваши объявления на '.$top_panel['settings']->getName().': в архив';
          $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
          $to = $adv_user->getEmail();
          $body = $this->getContainer()->get('templating')->render(
              'AdminAdminBundle:Advs:delete.html.twig',
              array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advs' => $user_advs)
          );
          $this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
          
        $output->writeln('ok');
    }
	
	function translate($text) {
		$translate_url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
		$translate_url .= '?key=trnsl.1.1.20161105T090710Z.5e73d5ea502f6e88.494a6a8e819b44d8d37736aa27e394894f87e7cb';
		$translate_url .= '&text='.$text.'&lang=ru';
		$tr_text = json_decode($this->get_page($translate_url));
		return $tr_text->text[0];
	}
	
	function get_page($url) {		
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);  
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
		curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot");
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = curl_exec($ch);
		curl_close($ch);   
		return $result; 
		
	}
  
  function my_ucfirst($string, $e ='utf-8') { 
        if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) { 
            $string = mb_strtolower($string, $e); 
            $upper = mb_strtoupper($string, $e); 
            preg_match('#(.)#us', $upper, $matches); 
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e); 
        } else { 
            $string = ucfirst($string); 
        } 
        return $string; 
    } 
    
  function downloadJs($file_url, $save_to)
    {
        $content = file_get_contents($file_url);
        file_put_contents($save_to, $content);
    }   
	
	function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    
    function str2url($str) {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }
	
	function to_url($str) {
        $str = strtolower($str);
        $str = preg_replace("~\'+~u", '', $str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);        
        $str = trim($str, "-");
        return $str;
    }
    
    function check_url($url) {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 404) {
            return null;
        }
        curl_close($handle);
        return $url;
    }
}
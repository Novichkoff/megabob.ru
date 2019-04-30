<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Admin\AdminBundle\Model\AdvsModerStat;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\SettingsQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use FOS\UserBundle\Propel\UserQuery;

class DisableCommand extends ContainerAwareCommand
{
    
	# Ежедневное Cron-задание
    protected function configure()
    {
        $this
            ->setName('cron:disable')
            ->setDescription('Daily Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         
        
        $top_panel = array();
        $top_panel['settings'] = SettingsQuery::create()->findOne();
        
        ############################################
        ##### Удаление неодобренных объявлений #####
        
        /*
		$advs = AdvsQuery::create()          
          ->filterByDeleted(true)
          ->filterByModerApproved(false)        
          ->find();
          
        foreach ( $advs as $adv ) {
           
           $name = $adv->getName();        
        
            $dir = 'images/a/images';
            $images = $adv->getAdvImagess();
            foreach ($images as $image) {
            
              $Thumbname = $image->getThumb();
              $MediumThumbname = $image->getMediumThumb();
              $Filename = $image->getPath();
              
              $fs = new Filesystem();
              if ($Thumbname) {
                try {
                    $fs->remove( $dir.'/'.$Thumbname );
                } catch (IOExceptionInterface $e) {                    
                }
              }
              if ($MediumThumbname) {
                try {                  
                    $fs->remove( $dir.'/'.$MediumThumbname ); 
                } catch (IOExceptionInterface $e) {
                }
              }
              if ($Filename) {
                try {                       
                    $fs->remove( $dir.'/'.$Filename );
                } catch (IOExceptionInterface $e) {
                }
              }
            }
           $adv->delete();            
          
        } 
		*/
                                 
        #########################################
        ##### Удаление удаленных объявлений #####
        
        /*
		$advs = AdvsQuery::create()          
          ->filterByDeleted(true)
          ->filterByPublishBeforeDate(array(
                "max" => strtotime( date("Y-m-d H:i:s", strtotime('-1 days')))
              ))         
          ->find();
          
        foreach ( $advs as $adv ) {
           
           $name = $adv->getName();        
        
            $dir = 'images/a/images';
            $images = $adv->getAdvImagess();
            foreach ($images as $image) {
            
              $Thumbname = $image->getThumb();
              $MediumThumbname = $image->getMediumThumb();
              $Filename = $image->getPath();
              
              $fs = new Filesystem();
              if ($Thumbname) {
                try {
                    $fs->remove( $dir.'/'.$Thumbname );
                } catch (IOExceptionInterface $e) {                    
                }
              }
              if ($MediumThumbname) {
                try {                  
                    $fs->remove( $dir.'/'.$MediumThumbname ); 
                } catch (IOExceptionInterface $e) {
                }
              }
              if ($Filename) {
                try {                       
                    $fs->remove( $dir.'/'.$Filename );
                } catch (IOExceptionInterface $e) {
                }
              }
            }
            
           $adv->delete();            
          
        }
		*/
		
        
        ##########################################
        #####     Выключение объявлений   ########
        
        $users_array = array();
        $advs = AdvsQuery::create()
          ->filterByEnabled(true)
          ->filterByDeleted(false)
          ->filterByPublishBeforeDate(array("max" => strtotime( date("Y-m-d H:i:s")  )))         
          ->find();
        
        foreach ( $advs as $adv ) {
            # Собираем все объявления пользователя
            $adv_user = UserQuery::create()->findOneById( $adv->getUserId() );		
                  if ($adv_user->getEmail() && $adv_user->getEmailStatus() && $adv_user->getEmailConfirm()) {
              $users_array[$adv->getUserId()][] = array(
                'id'		=> $adv->getId(),
                'name'		=> $adv->getName()
                );				
            }
            $moder_stat = new AdvsModerStat();
            $moder_stat->setModerId(1);
            $moder_stat->setAdvId($adv->getId());
            $moder_stat->setOperation('Выключение');
            $moder_stat->save();
            
            $adv->setEnabled(false);
            $adv->save();
        }
		
		foreach ( $users_array as $user_id=>$user_advs ) {
			$adv_user = UserQuery::create()->findOneById( $user_id );
			# Отсылаем сообщение пользователю, что объявление было выключено.
			$subject = 'Ваши объявления на '.$top_panel['settings']->getName().': выключение';
			$from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
			$to = $adv_user->getEmail();
			$body = $this->getContainer()->get('templating')->render(
				  'AdminAdminBundle:Advs:disable.html.twig',
				  array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advs' => $user_advs)
			);
			$this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
			# увеличиваем счетчик кол-ва отправленных писем
			$email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
			$adv_user->setEmailSendCnt($email_cnt+1);
			$adv_user->save();
		}		  

        ####################################################
        ##### Предупреждение о выключении объявлений #######
        
        $users_array = array();
        $advs = AdvsQuery::create()
              ->filterByEnabled(true)
              ->filterByDeleted(false)
              ->filterByPublishBeforeDate(array(
                    "min" => strtotime( date("Y-m-d H:i:s", strtotime('+4 days'))),
                    "max" => strtotime( date("Y-m-d H:i:s", strtotime('+5 days')))
                  ))         
              ->find();
              
            foreach ( $advs as $adv ) {
                # Собираем все объявления пользователя
          $adv_user = UserQuery::create()->findOneById( $adv->getUserId() );		
                if ($adv_user->getEmail() && $adv_user->getEmailStatus() && $adv_user->getEmailConfirm()) {
            $users_array[$adv->getUserId()][] = array(
              'id'		=> $adv->getId(),
              'name'		=> $adv->getName()
              );				
          }
        }
		foreach ( $users_array as $user_id=>$user_advs ) {
			$adv_user = UserQuery::create()->findOneById( $user_id );
			# Отсылаем сообщение пользователю, что объявление будет выключено.
			$subject = 'Ваши объявления на '.$top_panel['settings']->getName().': окончание показов';
			$from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
			$to = $adv_user->getEmail();
			$body = $this->getContainer()->get('templating')->render(
				  'AdminAdminBundle:Advs:disable_d.html.twig',
				  array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advs' => $user_advs)
			);
			$this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
			# увеличиваем счетчик кол-ва отправленных писем
			$email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
			$adv_user->setEmailSendCnt($email_cnt+1);
			$adv_user->save();
		}		
         
        #########################################
        ##### Старые объявления на удаление #####
        
        $advs = AdvsQuery::create()          
          ->filterByEnabled(false)
          ->filterByDeleted(false)
          ->filterByPublishBeforeDate(array(
                "max" => strtotime( date("Y-m-d H:i:s", strtotime('-31 days')))
              ))         
          ->find();
          
        foreach ( $advs as $adv ) {                       
          $adv->setDeleted(true);
          $adv->setPublishBeforeDate(date("Y-m-d H:i:s"));
          $adv->save();

          $moder_stat = new AdvsModerStat();
          $moder_stat->setModerId(1);
          $moder_stat->setAdvId($adv->getId());
          $moder_stat->setOperation('В архив');
          $moder_stat->save();          
        }
        
        ###################################################
        ##### Предупреждение об удалении объявлений #######
        
        $users_array = array();
        $advs = AdvsQuery::create()          
          ->filterByEnabled(false)
          ->filterByDeleted(false)
          ->filterByPublishBeforeDate(array(
                "max" => strtotime( date("Y-m-d H:i:s", strtotime('-30 days')))
              ))         
          ->find();
          
        foreach ( $advs as $adv ) {
            # Собираем все объявления пользователя
            $adv_user = UserQuery::create()->findOneById( $adv->getUserId() );		
            if ($adv_user->getEmail() && $adv_user->getEmailStatus() && $adv_user->getEmailConfirm()) {
              $users_array[$adv->getUserId()][] = array(
                'id'		=> $adv->getId(),
                'name'		=> $adv->getName()
                );				
            }
        }
		foreach ( $users_array as $user_id=>$user_advs ) {
			$adv_user = UserQuery::create()->findOneById( $user_id );
			# Отсылаем сообщение пользователю, что объявление будет удалено.
			$subject = 'Ваши объявления на '.$top_panel['settings']->getName().': в архив';
			$from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
			$to = $adv_user->getEmail();
			$body = $this->getContainer()->get('templating')->render(
				  'AdminAdminBundle:Advs:delete.html.twig',
				  array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advs' => $user_advs)
			);
			$this->getContainer()->get('mail_helper')->sendMailing($from, $to, $subject, $body);
			# увеличиваем счетчик кол-ва отправленных писем
			$email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
			$adv_user->setEmailSendCnt($email_cnt+1);
			$adv_user->save();
		}		

		#####################################
        ##### Удаляем старую статистику #####
        
        $advs_stats = AdvsStatQuery::create()
              ->filterByStatDate(array(
                "max" => strtotime( date("Y-m-d H:i:s", strtotime('-14 days')))
              ))			
              ->delete();		

        $output->writeln('ok');
    }
}
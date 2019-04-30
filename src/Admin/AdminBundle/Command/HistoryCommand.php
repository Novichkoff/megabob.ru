<?php

namespace Admin\AdminBundle\Command;

use \Criteria;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\JobsQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\SiteHistory;

class HistoryCommand extends ContainerAwareCommand
{

    # Ежедневное Cron-задание
    protected function configure()
    {
        $this
            ->setName('cron:history')
            ->setDescription('Daily Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
                
        $advs = AdvsQuery::create()            
            ->count();
            
        $approved = AdvsQuery::create()
            ->filterByDeleted(false)
            ->filterByModerApproved(true)
            ->filterByEnabled(true)
            ->count();
            
        $shops = ShopsQuery::create()
            ->filterByEnabled(true)
            ->count();
            
        $s_advs = AdvsQuery::create()            
            ->find();
        
        $twitter = $facebook = $vk_share = $ok = 0;
        foreach ($s_advs as $adv) {
            $twitter += $adv->getTwitter();
            $facebook += $adv->getFacebook();
            $vk_share += $adv->getVkShare();
            $ok += $adv->getOdnoklassniki();
        }
		
		$today_advs = AdvsQuery::create()            
            ->filterByCreateDate(array("min" => strtotime( date("Y-m-d").'00:00:00' ) ))
			->count();
		
		$google_advs = AdvsQuery::create()            
            ->filterByGoogleDate(null, Criteria::NOT_EQUAL)
			->count();
			
		$yandex_advs = AdvsQuery::create()            
            ->filterByYandexDate(null, Criteria::NOT_EQUAL)
			->count();
        
        $site_history = new SiteHistory();
		$site_history->setDate(strtotime( date("Y-m-d H:i:s", strtotime('+1 minutes'))));
        $site_history->setAllAdvs($advs);
        $site_history->setActiveAdvs($approved);
		$site_history->setTodayAdvs($today_advs);
		$site_history->setGoogleAdvs($google_advs);
		$site_history->setYandexAdvs($yandex_advs);
        $site_history->setCompanies($shops);
        $site_history->setTwitter($twitter);
        $site_history->setFacebook($facebook);
        $site_history->setVk($vk_share);
        $site_history->setOk($ok);
        $site_history->save();        

        $output->writeln('ok');
    }
}
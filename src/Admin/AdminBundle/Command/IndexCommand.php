<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\UserAccountQuery;
use Symfony\Component\Filesystem\Filesystem;
use Admin\AdminBundle\Controller\YandexXML;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class IndexCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        $this
            ->setName('cron:index')
            ->setDescription('Hourly Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {               
        
      # Индексация Google 
      /*
      $advs = AdvsQuery::create()
              ->filterByDeleted(false)
              ->filterByModerApproved(true)
              ->filterByEnabled(true)
              ->where('google_date is NULL')
              ->orderByGoogleIndexDate('ASC')
              ->limit(20)
              ->find();
              
      foreach ( $advs as $adv ) {
        $output->writeln($adv->getId());
        $adv->setGoogleIndexDate(date("Y-m-d H:i:s"));
        $adv->save();
        
        if ($adv->getGoogleDate() == NULL) {
          $sq = "https://www.google.ru/search?q=info%3Ahttps%3A%2F%2Fclaso.ru%2Frussia%2F".$adv->getId();
          $body = $this->get_page($sq);
          preg_match_all("/Результатов: (\d)/i", $body, $out);			
          if (@$out[0][0]) {
            $output->writeln('Ok, Google');
            $adv->setGoogleIndexDate(date("Y-m-d H:i:s"));
            $adv->setGoogleDate(date("Y-m-d H:i:s"));
            $adv->save();
          } else {
            $adv->setGoogleIndexDate(date("Y-m-d H:i:s"));
            $adv->save();
            $output->writeln('No, Google');
          }
        }
      }      
      */
		  
		  # Индексация Яндекс
		  /*
      $num = (int)date('H');
      
		  $yxml = new YandexXML;
		  $yxml->set_param(array('query' => 'url:claso.ru/russia/'.$num.'*'));
		  $xml = $yxml->request();
		  $found =(int)$xml->response->results->grouping->found;		  
		  $pages = round($found/100, 0, PHP_ROUND_HALF_UP);		  
		  for ($i = 0; $i <= $pages-1; $i++) {
        $yaxml = new YandexXML;
			  $yaxml->set_param(array('query' => 'url:claso.ru/russia/'.$num.'*','page' => $i));
			  $xxml = $yaxml->request();        
			  foreach ($xxml->response->results->grouping->group as $group) {
          $id = (int)str_replace("https://Claso.ru/russia/", "", (string)$group->doc->url);				  
				  $adv = AdvsQuery::create()->findOneById($id);				  
				  if ($adv) {
					  $adv->setYandexDate(date("Y-m-d H:i:s", strtotime($group->doc->modtime)));
					  $adv->save();
				  }
			  }		  
		  }
      */
		  
		  // 2a00:1c70:1111:1::7

      $output->writeln('ok');
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
    
}
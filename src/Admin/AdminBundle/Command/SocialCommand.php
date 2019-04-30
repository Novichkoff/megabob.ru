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
use Admin\AdminBundle\Command\TwitterAPIExchange;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SocialCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        $this
            ->setName('cron:social')
            ->setDescription('Hourly Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
               
        //require_once('TwitterAPIExchange.php');
        /*
        $settings = array(
            'oauth_access_token' => "2922605871-WZMkHJjeAiLiUa1h7fQMJ4nmDJQl9wNwufPUYPd",
            'oauth_access_token_secret' => "ZEXYHZAThhGgXALk1GOHdbbO3RQA5DPStbFCeZE9xaveQ",
            'consumer_key' => "3O2tczRAd77GnZhIiARBW84wW",
            'consumer_secret' => "kzfXixDvdB3FhUTnBgQijzDbLbVSdmkwVSublR77yjz9ufvLLp"
        );        
        */ 
        $advs = AdvsQuery::create()
            ->filterByDeleted(false)
            ->filterByModerApproved(true)
            ->filterByEnabled(true)            
            ->filterBySocialDate(array("max" => strtotime( "-1 days", strtotime( date("Y-m-d H:i:s") ) )))            
            ->limit(100)
            ->find();
            
        
        foreach ( $advs as $adv ) {          
          $new_twitter = $new_facebook = $new_o = $new_vk_share = 0;
          //$url = urlencode("https://claso.ru/russia/".$adv->getId());
          
          //количество твитов в Twitter
          // Больше не работает          
          /*
          $url = 'https://api.twitter.com/1.1/search/tweets.json';
          $getfield = '?q='.$url;
          $requestMethod = 'GET';
          $twitter = new TwitterAPIExchange($settings);
          $twitter_request = $twitter->setGetfield($getfield)
                                     ->buildOauth($url, $requestMethod)
                                     ->performRequest(); 
          
          $cnt = json_decode($twitter_request);           
          $new_twitter = $cnt->search_metadata->count - $adv->getTwitter();          
          if ( $new_twitter > 0 ) {
            $adv->setTwitter($cnt->search_metadata->count);            
          }
          */
          
          //количество лайков в facebook
          /*
          $facebook_request = $this->get_page('http://graph.facebook.com/'.$url);
          $fb = json_decode($facebook_request);          
          $vb_c = 0;
          if ($fb) if(property_exists($fb,'shares')) $vb_c = $fb->shares;          
          $new_facebook = $vb_c - $adv->getFacebook();
          if ( $new_facebook > 0 ) {
            $adv->setFacebook($vb_c);						
          } 
          */
          
          //количество расшариваний на vk          
          /*
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $vk_query = 'http://vk.com/share.php?act=count&index=1&url='.$url;
          curl_setopt($ch, CURLOPT_URL, $vk_query);
          $vk_request = curl_exec ($ch);          
          $temp = array();
          preg_match('/^VK.Share.count\(1, (\d+)\);$/i',$vk_request,$temp);
          $vk_c = (int)$temp[1];
          $new_vk_share = $vk_c - $adv->getVkShare();
          if ( $new_vk_share > 0 ) {
            $adv->setVkShare($vk_c);            
          } 
          */          
          
          //инфа по Одноклассникам
          /*
          $odnoklassniki_request = $this->get_page('http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref='.$url);
          $temp = array();
          preg_match("/^ODKL.updateCount\('[\d\w]+','(\d+)'\);$/i",$odnoklassniki_request,$temp);
          $o_c = (int)$temp[1];
          $new_o = $o_c - $adv->getOdnoklassniki();
          if ( $new_o > 0 ) {
            $adv->setOdnoklassniki($o_c);            
          }
          
          
          $adv->setSocialDate(date("Y-m-d H:i:s"));
          $adv->save();
          $output->writeln($adv->getId().' - '.$adv->getTwitter().' - '.$adv->getFacebook().' - '.$adv->getVk().' - '.$adv->getVkShare().' - '.$adv->getOdnoklassniki());
          */
          //sleep(1);
		  
        }        

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
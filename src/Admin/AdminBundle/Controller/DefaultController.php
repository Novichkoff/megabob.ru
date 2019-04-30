<?php

namespace Admin\AdminBundle\Controller;

use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\PartnersQuery;
use Admin\AdminBundle\Model\SiteHistoryQuery;
use Admin\AdminBundle\Model\SettingsQuery;
use Admin\AdminBundle\Form\SettingsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $advs = AdvsQuery::create()            
            ->count();
		 
        $approved = AdvsQuery::create()
            ->filterByDeleted(false)
            ->filterByModerApproved(true)
            ->filterByEnabled(true)
            ->count();
            
        $disabled = AdvsQuery::create()
            ->filterByDeleted(false)            
            ->filterByEnabled(false)
            ->count();
            
        $deleted = AdvsQuery::create()
            ->filterByDeleted(true)            
            ->filterByEnabled(false)
            ->count();
		
        $shops = ShopsQuery::create()
            ->filterByEnabled(true)
            ->count();
		
        $today_advs = AdvsQuery::create()            
                ->filterByCreateDate(array("min" => strtotime( date("Y-m-d").'00:00:00' ) ))
          ->count();
        
        $google_advs = AdvsQuery::create()            
                ->filterByGoogleDate(null, Criteria::NOT_EQUAL)
          ->count();
          
        $yandex_advs = AdvsQuery::create()            
                ->filterByYandexDate(null, Criteria::NOT_EQUAL)
          ->count();
		
        $history = SiteHistoryQuery::create()
          ->orderByDate('desc')
          ->limit(10)
          ->find();
        
        $statistic = $this->get_statistic();
        $money_today = $this->get_money('today');
        $money_yesterday = $this->get_money('yesterday');
        
        return $this->render('AdminAdminBundle:Default:index.html.twig',array(
          'for_moders' => $for_moders,
          'history'    => $history,
          'advs'       => $advs,
          'today_advs' => $today_advs,
          'google_advs' => $google_advs,
          'yandex_advs' => $yandex_advs,
          'approved'   => $approved,
          'disabled'   => $disabled,
          'deleted'   => $deleted,
          'shops'      => $shops,
          'statistic'  => $statistic,
          'money_today' => $money_today,
          'money_yesterday' => $money_yesterday 
        ) );
    }
    
    # Редактирование настроек
    public function settingsAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $settings = SettingsQuery::create()->findOne();        
        
        $icon = $settings->getIcon();
        $logo = $settings->getLogo();

        $form = $this->createForm(new SettingsType(), $settings);
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($form['icon']->getData()) {
                $dir = 'images';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/ico': $Filename = 'favicon.ico'; break;                    
                }
                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $settings->setIcon($Filename);                    

                    /*
                    $image = new Image($dir.'/'.$Filename); 
                    $image->thumbnail_full(300, 225);  
                    $image->save($dir.'/'.$Filename);
                    unset($image);
                    */
                }
            } else {
                $settings->setIcon($icon);
            }   
            if ($form['logo']->getData()) {
                $dir = 'images';
                $file_type = $form['logo']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = 'logo.png'; break;
                    case 'image/jpeg': $Filename = 'logo.jpg'; break;
                    case 'image/gif': $Filename = 'logo.gif'; break;
                }
                if ($Filename) {
                    $form['logo']->getData()->move($dir, $Filename);
                    $settings->setLogo($Filename);                    
                    
                    $image = new Image($dir.'/'.$Filename); 
                    //$image->thumbnail_full(300, 225);  
                    $image->save($dir.'/'.$Filename);
                    unset($image);
                    
                }
            } else {
                $settings->setLogo($logo);
            }               
            $settings->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Настройки успешно изменены!'
            );

            return $this->redirect($this->generateUrl('admin_admin_homepage'));
        }
        
        $image = $settings->getLogo();

        return $this->render('AdminAdminBundle:Default:settings.html.twig', array(
                'form'              => $form->createView(),
                'image'             => $image,
                'for_moders'        => $for_moders
            )
        );
    }
	
	public function googleAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();
		
		
		
		$client_id = '534564669042-ggame2bq1g4560q59b54fihaqrkv2m2h.apps.googleusercontent.com'; //Client ID
		$service_account_name = '534564669042-ggame2bq1g4560q59b54fihaqrkv2m2h@developer.gserviceaccount.com'; //Email Address
		$key_file_location = '/var/www/claso.ru/app/config/claso-274f0e97478c.p12'; //key.p12
		$accessToken = file_get_contents('/var/www/claso.ru/app/config/claso-9a125059bd67.json');
		$scope = 'https://www.googleapis.com/auth/adsense.readonly';
		
		$client = new \Google_Client();
		$client->setApplicationName("claso");
		
		if (isset($_SESSION['service_token'])) {
		  $client->setAccessToken($_SESSION['service_token']);
		}
		$key = file_get_contents($key_file_location);
		$cred = new \Google_Auth_AssertionCredentials(
			$service_account_name,
			array($scope),
			$key
		);
		$client->setAssertionCredentials($cred);
		if ($client->getAuth()->isAccessTokenExpired()) {
		  $client->getAuth()->refreshTokenWithAssertion($cred);
		}
		$_SESSION['service_token'] = $client->getAccessToken();
		var_dump($client);
		
		//$service    = new \Google_Service_AdSense($client);
		//$accounts = $service->accounts->listAccounts(); */
		
		//var_dump($service);
	 
		$params = array(
			'for_moders' => $for_moders			
		);	 
		        
        return $this->render('AdminAdminBundle:Default:google.html.twig', $params);
    }
    
    public function usageCpuAction()
    {

      $loadavgstats = substr(file_get_contents('/proc/loadavg'), 0, 4)*100;      
      preg_match_all("/processor/",file_get_contents('/proc/cpuinfo'),$out);
      $loadavgstats = round($loadavgstats/(count($out[0])));

      return new Response(json_encode($loadavgstats));
    }
    
    public function usageMemoryAction()
    {

      exec('free -m', $retval);
      $all = (int)substr($retval[1], 14, 4);
      $used = (int)substr($retval[1], 25, 4);
      $memory = round(($used*100)/$all);

      return new Response(json_encode($memory));
    }
    
    function get_statistic()
        {
            // Запрос токена
			// https://oauth.yandex.ru/authorize?response_type=token&client_id=ea860de0a0cc446291766e6ea04d9ae0
      
      // https://api-metrika.yandex.ru/stat/v1/data/bytime?date1=2017-01-01&date2=2017-01-14&group=day&dimensions=ym:s:%3Cattribution%3ETrafficSource&attribution=last&ids=27434243&metrics=ym:s:visits&oauth_token=AQAAAAAHIgk2AAJJPqypP7PPi0hJrGLF2BauYgs
			
			$token = 'AQAAAAAHIgk2AAVWRRtJsn_FdkOdl0Lgx1qa8ZQ';
            $id = '45886410';
            $date1 = date('Y-m-d');
            $date2 = date('Y-m-d',strtotime( "-5 days", strtotime( date("Y-m-d") ) ));
            $metrics = "ym:s:visits,ym:s:pageviews,ym:s:users,ym:s:percentNewVisitors,ym:s:pageDepth";
            $link = 'https://api-metrika.yandex.ru/stat/v1/data/bytime?date1='.$date2.'&date2='.$date1.'&group=day&ids='.$id.'&oauth_token='.$token.'&metrics='.$metrics;
             
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            $string = curl_exec($ch);                       
            if ($string) {
              $data = json_decode($string);
            } else {
              $data = NULL;
            }
            if (@$data->errors) $data = NULL;
            return $data;
            var_dump($data);
        }
        
        // https://partner2.yandex.ru/api/statistics/get.json?oauth_token=AQAAAAAHIgk2AAJJPqypP7PPi0hJrGLF2BauYgs&lang=ru&pretty=1&level=advnet_context_on_site&entity_field=page_id&field=rtb_partner_wo_nds&&period=today&filter=[%22page_id%22,%22=%22,%22190822%22]
		
	function get_money($period = 'today')
        {
            		
			      $token = 'AQAAAAAHIgk2AAJJPqypP7PPi0hJrGLF2BauYgs';
            $link = 'https://partner2.yandex.ru/api/statistics/get.json?oauth_token='.$token.'&lang=ru&pretty=1&level=advnet_context_on_site&entity_field=page_id&field=rtb_partner_wo_nds&&period='.$period.'&filter=[%22page_id%22,%22=%22,%22190822%22]';
              
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            $string = curl_exec($ch);                       
            if ($string) {
              $data = json_decode($string);
            } else {
              $data = NULL;
            }
            if (@$data->errors) $data = NULL;            
            return $data;
            //var_dump($data);
        }
        
  function show_size($f,$format=true) 
		{ 
			if($format) 
			{ 
					$size=$this->show_size($f,false); 
					return $this->byte_format($size);
			} else 
			{ 
					if(is_file($f)) return filesize($f); 
					$size=0; 
					$dh=opendir($f); 
					while(($file=readdir($dh))!==false) 
					{ 
							if($file=='.' || $file=='..') continue; 
							if(is_file($f.'/'.$file)) $size+=filesize($f.'/'.$file); 
							else $size+=$this->show_size($f.'/'.$file,false); 
					} 
					closedir($dh); 
					return $size+filesize($f); // +filesize($f) for *nix directories 
			} 
		}
	function byte_format($size) {
		if($size<=1024) return $size; 
		else if($size<=1024*1024) return round($size/(1024),2).' Kb'; 
		else if($size<=1024*1024*1024) return round($size/(1024*1024),2).' Mb'; 
		else if($size<=1024*1024*1024*1024) return round($size/(1024*1024*1024),2).' Gb'; 
		else if($size<=1024*1024*1024*1024*1024) return round($size/(1024*1024*1024*1024),2).' Tb'; //:))) 
		else return round($size/(1024*1024*1024*1024*1024),2).' Pb';
	}		

}

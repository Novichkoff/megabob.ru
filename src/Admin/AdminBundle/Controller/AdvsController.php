<?php

namespace Admin\AdminBundle\Controller;

use \Criteria;
use Admin\AdminBundle\Model\AdvComplainePeer;
use Admin\AdminBundle\Model\AdvComplaineQuery;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Form\AdvType;
use Admin\AdminBundle\Form\AdvFullType;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\AdvsModerStat;
use Admin\AdminBundle\Model\AdvsQuery;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\TransactionsQuery;
use Admin\AdminBundle\Model\UserAccountQuery;
use Admin\AdminBundle\Model\UserAccount;
use Admin\AdminBundle\Model\SettingsQuery;
use Abraham\TwitterOAuth\TwitterOAuth;
use Admin\AdminBundle\Controller\Vkontakte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class AdvsController extends Controller
{

    # *********************
    # Объявления
    # *********************
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        return $this->render('AdminAdminBundle:Advs:index.html.twig',array(
                'for_moders' => $for_moders
            )
        );
    }
    # ---------------------------
    # Отображение всех объявлений
    # ---------------------------
    public function advsAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $advs = AdvsQuery::create()            
            ->join('AdvComplaine',Criteria::LEFT_JOIN) 
            ->join('AdvPrice',Criteria::LEFT_JOIN)
            ->orderByDeleted('asc')  
            ->orderByEnabled('desc')    
            ->orderByModerApproved('asc')
            ->orderBy('AdvComplaine.id','desc')
            ->orderByCreateDate('desc');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $advs,
            $this->get('request')->query->get('page', 1),
            20
        );		

        return $this->render('AdminAdminBundle:Advs:advs.html.twig',array(
                'for_moders' => $for_moders,
                'pagination' => $pagination
            )
        );
    }

    # ---------------------------
    # Поиск объявлений
    # ---------------------------
    public function findAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();
        
        $advs = AdvsQuery::create()            
            ->join('AdvComplaine',Criteria::LEFT_JOIN) 
            ->join('AdvPrice',Criteria::LEFT_JOIN)
            ->orderByDeleted('asc')  
            ->orderByEnabled('desc')    
            ->orderByModerApproved('asc')
            ->orderBy('AdvComplaine.id','desc')
            ->orderByCreateDate('desc');        
        if (@$request->query->get('adv')) {
          $advs->_or()->filterByText((string)$request->query->get('adv')); 
          $advs->_or()->filterById((int)$request->query->get('adv'));           
        }
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $advs,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Advs:advs.html.twig',array(
                'for_moders' => $for_moders,
                'pagination' => $pagination
            )
        );
    }

    # -------------------------
    # Редактирование объявления
    # -------------------------
    public function editAction($id, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
        $adv = AdvsQuery::create()
            ->joinWith('User')
            ->findOneById($id);
        
        if (!$adv) {
            throw $this->createNotFoundException(
                'Объявление не существует'
            );
        }
        
        # Проверяем объявление на совпадения
        $similar_adv = '';
        $user_advs = AdvsQuery::create()			
            ->filterByUserId($adv->getUserId())
            ->filterByDeleted(false)
            ->filterByRegionId($adv->getRegionId())
            ->find();
        $alert = 0;
        foreach ($user_advs as $user_adv) {           
          if ($user_adv->getId() != $adv->getId()) {
            # Проверяем название
            if ($user_adv->getName() == $adv->getName() && $alert==0) {              
              $alert = 1;
              $similar_adv = 'Есть полное совпадение по названию с объявлением № <a href="'.$user_adv->getId().'" title="'.$user_adv->getDescription().'">'.$user_adv->getId().' - '.$user_adv->getName().'</a> : '.$user_adv->getRegions()->getName();
            }
            # Проверяем описание на точное совпадение
            if ($user_adv->getDescription() == $adv->getDescription() && $alert==0) {             
              $alert = 1;
              $similar_adv = 'Есть полное совпадение по описанию с объявлением № <a href="'.$user_adv->getId().'" title="'.$user_adv->getDescription().'">'.$user_adv->getId().' - '.$user_adv->getName().'</a> : '.$user_adv->getRegions()->getName();
            } elseif ($alert==0) {
              # Проверяем совпадения слов в описании               
              similar_text($adv->getDescription(),$user_adv->getDescription(),$procent);			   
              if (@$procent>80) {             
                $alert = 1;
                $similar_adv = 'Есть около '.(int)$procent.'% совпадений слов в описании с объявлением № <a href="'.$user_adv->getId().'" title="'.$user_adv->getDescription().'">'.$user_adv->getId().' - '.$user_adv->getName().'</a> : '.$user_adv->getRegions()->getName();
              }			   
            }
          }
        }        

        $moder_approved = $adv->getModerApproved();
        $enabled = $adv->getEnabled();

        # Заполняем Дополнительные поля категории
        $category = AdCategoriesQuery::create()->findPk($adv->getCategoryId());
        if ($category) {
            $category_fields = AdCategoriesFieldsQuery::create()
                ->filterByCategoryId(array($category->getParentId(), $adv->getCategoryId()))
                ->findByArray(array(
                        'deleted'       => false,
                        'enabled'       => true
                    )
                );
            foreach ($category_fields as $category_field) {

                $adv_param = AdvParamsQuery::create()->findOneByArray(array(
                    'advId'     => $id,
                    'fieldId'   => $category_field->getId()
                    )
                );
                if ($adv_param) {
                    if ($category_field->getType() == 2 || $category_field->getType() == 6 || $category_field->getType() == 7 || $category_field->getType() == 8) {
                        $adv->{'params_'.$category_field->getId()} = $adv_param->getValueId();
                    } else {
                        $adv->{'params_'.$category_field->getId()} = $adv_param->getTextValue();
                    }
                } else {
                    $adv->{'params_'.$category_field->getId()} = '';
                }
            }
        }

        $form = $this->createForm(new AdvFullType(), $adv);

        $form->handleRequest($request);

        $images = AdvImagesQuery::create()->findByAdvId($adv->getId());
        $videos = AdvVideosQuery::create()->findByAdvId($adv->getId());
        $adv->stats = AdvsStatQuery::create()->filterByAdvId($adv->getId())->orderByStatDate('DESC')->limit(10)->find();

        if ($form->isValid()) {
            
            $moder_stat = new AdvsModerStat();
            $moder_stat->setModerId($user->getId());
            $moder_stat->setAdvId($adv->getId());
              
            $adv_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $adv->getUserId()));

            # Отсылаем сообщение пользователю, если объявление было выключено.
            if ($adv->getEnabled() != $enabled && $adv->getEnabled() == FALSE) {
			  
			  $moder_stat->setOperation('Выключение');		  
			  
              $top_panel = array();
              $top_panel['settings'] = SettingsQuery::create()->findOne();
        
              $subject = 'Ваше объявление на '.$top_panel['settings']->getName();
              $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
              $to = $adv_user->getEmail();
              $body = $this->renderView(
                  'AdminAdminBundle:Advs:email.txt.twig',
                  array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advs' => [$adv])
              );
              if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) {
                $this->get('session')->getFlashBag()->add('notice1','Письмо о нарушении правил успешно отправлено');
                # увеличиваем счетчик кол-ва отправленных писем
                $email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
                $adv_user->setEmailSendCnt($email_cnt+1);
                $adv_user->save();
              } 
            } 
            # Вставляем дату публикации при одобрении объявления модератором
            if ($adv->getModerApproved() != $moder_approved && $adv->getModerApproved() == TRUE) {               
              $packet = $adv->getAdvPacketss();
              if (@$packet[0]){
				  if ($packet[0]->getPaid() == 1) {
					  $packet[0]->setUseBefore(strtotime( "+".$packet[0]->getPackets()->getDays()." days", strtotime( date("Y-m-d H:i:s") ) ) );
					  $packet[0]->save();
				  }
			  } else {
				  $packet = new AdvPackets();
				  $packet->setAdvId($adv->getId());
				  $packet->setPacketId(3);
				  $packet->setEnabled(true);
				  $packet->setPaid(true);
				  $packet->setPaidDate(date("Y-m-d H:i:s"));
				  $packet->setUseBefore(strtotime( "+".$packet->getPackets()->getDays()." days", strtotime( date("Y-m-d H:i:s") ) ) );
				  $packet->save();
			  }			  
              
              
              $user_account = UserAccountQuery::create()
                  ->filterByFosUserId($adv_user->getId())
                  ->findOne();
              if (!$user_account) {
                $user_account = new UserAccount();
                $user_account->setFosUserId($adv_user->getId());
              }                       
              $user_account->save();              
			  
              $moder_stat->setOperation('Одобрение');              
              
              // Автоматическая публикация в Твиттер
              $this->twitterPost($adv);
              // Автоматическая публикация в VK
              $this->vkPostOnWall($adv);
                
              $adv->setSocialDate(strtotime( "-2 days", strtotime( date("Y-m-d H:i:s") ) ));
			  
				$sum = 50;
				if ($user_account){
					$user_account->setBalance($user_account->getBalance() + $sum);
					$user_account->save();
					$transaction = new Transactions();
					$transaction->setEmail('bonus@megabob.ru');
					$transaction->setSum($sum);
					$transaction->setFosUserId($adv->getUserId());
					$transaction->setType('Бонус за объявление');
					$transaction->setTransactionDate(date("Y-m-d H:i:s"));
					$transaction->save();
				}
                            
            }
			
			if ($adv->getDeleted()) $moder_stat->setOperation('В архив');

            if ($adv->getShopId() == 0) $adv->setShopId(NULL);
            # Сохраняем Объявление
            $adv->save();			
            $moder_stat->save();

            # Заполняем Дополнительные поля категории и сохраняем их
            foreach ($category_fields as $category_field) {
                $adv_params = AdvParamsQuery::create()
                    ->filterByAdvId($adv->getId())
                    ->findOneByFieldId($category_field->getId());
                if (!$adv_params) { 
                    $adv_params = new AdvParams(); 
                    $adv_params->setAdvId($adv->getId()); 
                    $adv_params->setFieldId($category_field->getId());
                }
                if ($category_field->getType() == 2 || $category_field->getType() == 6 || $category_field->getType() == 7 || $category_field->getType() == 8) {
                  $adv_params->setValueId($adv->{'params_'.$category_field->getId()});
                  $adv_params->setTextValue(NULL);
                } else {
                  $adv_params->setTextValue($adv->{'params_'.$category_field->getId()});
                  $adv_params->setValueId(NULL);
                }
                $adv_params->save();
            }

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Объявление №'.$adv->getId().' "'.$adv->getName().'" успешно обновлено!'
            );

            return $this->redirect($this->generateUrl('admin_admin_advspage'));
        }
        
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        return $this->render('AdminAdminBundle:Advs:edit.html.twig',array(
            'for_moders'        => $for_moders,
            'form'              => $form->createView(),
            'adv'               => $adv,
            'images'            => $images,
            'videos'            => $videos,
            'similar_adv' 		=> $similar_adv
            )
        );
    }

    # --------------------
    # VK
    # --------------------
    function vkPostOnWall($adv = null)
    {        
        /*
        if ($adv) {
          $image = @$adv->getAdvImagess()[0]?$adv->getAdvImagess()[0]->getPath():NULL;
          // Будем публиковать только с картинками
          if ($image) {
            $accessToken = '2caa3f455f2548dda7d3fb218502a41f8b756ca5a6484f141f9798686d511a2745c3c0c755a2aa9ecc6ab';
            $vkAPI = new Vkontakte(['access_token' => $accessToken]);        
            $publicID = 152672069;
            $adv_url = $this->generateUrl('site_adv_page',array('category'=>$adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),'subcategory'=>$adv->getAdCategories()->getAlias(),'region'=>$adv->getRegions()->getAlias(),'id'=>$adv->getId(),'alias'=>$adv->getAlias()),true);
            $vkAPI->postToPublic($publicID, $adv->getName()." ".$adv->getRegions()->getPagetitle().".\n Подробнее на ".$adv_url, '/var/www/megabob.ru/web/images/a/images/'.$image, ['MegaBob.ru', 'Бесплатные объявления '.$adv->getRegions()->getNet(), $adv->getAdCategories()->getName()]);
          }          
        }
        */        
    }
    
    # --------------------
    # Telegram
    # --------------------
    function telegramPost($adv = null)
    {        
        /*
        if ($adv) {          
          $token = "366655492:AAH7rNtNASdn3ZegHL9M4zt9bs1pZ-5S8Gc";
          $bot = new \TelegramBot\Api\Client($token);
          $chat_id = file_get_contents("bot.chat.id");
          $message = "<a href='https://claso.ru/russia/".$adv->getId()."'>".$adv->getName()." ".$adv->getRegions()->getPagetitle()."</a>";
          $bot->sendMessage($chat_id, $message, 'html');                 
        }
        */
    }
    
    # --------------------
    # Одобрение объявления
    # --------------------
    public function moderedAction($id, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
        $adv = AdvsQuery::create()->findOneById($id);

        if (!$adv) {
            throw $this->createNotFoundException(
                'Объявление не существует'
            );
        }        

        $name = $adv->getName();	
		
        $adv_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $adv->getUserId()));
        $adv->setSocialDate(strtotime( "-2 days", strtotime( date("Y-m-d H:i:s") ) ));                
        $adv->setModerApproved(TRUE);
        $adv->save();
		
		$sum = 50;				
		$account = UserAccountQuery::create()->findOneByFosUserId($adv->getUserId()); 
		if ($account){
			$account->setBalance($account->getBalance() + $sum);
			$account->save();
			$transaction = new Transactions();
			$transaction->setEmail('bonus@megabob.ru');
			$transaction->setSum($sum);
			$transaction->setFosUserId($adv->getUserId());
			$transaction->setType('Бонус за объявление');
			$transaction->setTransactionDate(date("Y-m-d H:i:s"));
			$transaction->save();
		}
        
        $packet = $adv->getAdvPacketss();
        if ($packet[0]->getPaid() == 1) {
            $packet[0]->setUseBefore(strtotime( "+".$packet[0]->getPackets()->getDays()." days", strtotime( date("Y-m-d H:i:s") ) ) );
            $packet[0]->save();
        }  

        $this->get('session')->getFlashBag()->add(
            'noticesite',
            'Объявление №'.$id.' "'.$adv->getName().'" успешно одобрено!'
        );
		
        $moder_stat = new AdvsModerStat();
        $moder_stat->setModerId($user->getId());
        $moder_stat->setAdvId($adv->getId());
        $moder_stat->setOperation('Одобрение');
        $moder_stat->save();
        
        $this->twitterPost($adv);
        $this->vkPostOnWall($adv);
        
        return $this->redirect($referer = $request->headers->get('referer'));
    }
    
    // Автоматическая публикация в Твиттер
    function twitterPost($adv) {
      
      $settings = SettingsQuery::create()->findOne();
      
      $parameters = array();
      $connection = new TwitterOAuth("kdjV08AX3XrSYPkx2Jay9WUt7", "LBBmX6ouIo2Ykq6u4o45AyNMgKnz9Btk2g0DYnr8tHjyvz6UlB", "902723047773413376-OpbBp1CEiBvZIpS8UGtg1UHq0gxkwqO", "VYeHyHDGyTPOFks4MoPubzxrku0mlMTqVzONM5r6Y5NKA");
                   
      $adv_url = $this->generateUrl('site_adv_page',array('category'=>$adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),'subcategory'=>$adv->getAdCategories()->getAlias(),'region'=>$adv->getRegions()->getAlias(),'id'=>$adv->getId(),'alias'=>$adv->getAlias()));
      $parameters['status'] = "#MegaBob ".$adv->getName()." ".$adv->getRegions()->getPagetitle()." ".$settings->getUrl().$adv_url;
      if (count($adv->getAdvImagess())) {
        $image = $adv->getAdvImagess()[0]->getPath();
        $media1 = $connection->upload('media/upload', ['media' => '/var/www/'.mb_strtolower($settings->getName()).'/web/images/a/images/'.$image]);
        $parameters['media_ids'] = $media1->media_id_string;
      }
      
      $result = $connection->post('statuses/update', $parameters);
      
    }        
    
    # -------------------------------------------
    # Одобрение объявления на странице объявления
    # -------------------------------------------
    public function moderedFromSiteAction($id, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
		$adv = AdvsQuery::create()->findOneById($id);

        if (!$adv) {
            throw $this->createNotFoundException(
                'Объявление не существует'
            );
        }        

        $name = $adv->getName();	
		
        $adv_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $adv->getUserId()));      
		
		$adv->setSocialDate(strtotime( "-2 days", strtotime( date("Y-m-d H:i:s") ) ));                
        $adv->setModerApproved(TRUE);
        $adv->save();
		
		$sum = 50;				
		$account = UserAccountQuery::create()->findOneByFosUserId($adv->getUserId()); 
		if ($account){
			$account->setBalance($account->getBalance() + $sum);
			$account->save();
			$transaction = new Transactions();
			$transaction->setEmail('bonus@megabob.ru');
			$transaction->setSum($sum);
			$transaction->setFosUserId($adv->getUserId());
			$transaction->setType('Бонус за объявление');
			$transaction->setTransactionDate(date("Y-m-d H:i:s"));
			$transaction->save();
		}
        
        $packet = $adv->getAdvPacketss();
        if ($packet[0]->getPaid() == 1) {
            $packet[0]->setUseBefore(strtotime( "+".$packet[0]->getPackets()->getDays()." days", strtotime( date("Y-m-d H:i:s") ) ) );
            $packet[0]->save();
        }                       
        
        $this->get('session')->getFlashBag()->add(
            'noticesite',
            'Объявление №'.$id.' "'.$adv->getName().'" успешно одобрено!'
        );
		
		$moder_stat = new AdvsModerStat();
		$moder_stat->setModerId($user->getId());
		$moder_stat->setAdvId($adv->getId());
		$moder_stat->setOperation('Одобрение');
		$moder_stat->save();
    
		$advs_next = AdvsQuery::create()            
			->filterByArray( array(
                    'enabled' => true,
                    'deleted' => false,
                    'moderApproved' => false
                )
            )
            ->findOne();			
        
        if(@$advs_next->getId()) {
          return $this->redirect($this->generateUrl('site_adv_page',array('category'=>$advs_next->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),'subcategory'=>$advs_next->getAdCategories()->getAlias(),'region'=>$advs_next->getRegions()->getAlias(),'id'=>$advs_next->getId(),'alias'=>$advs_next->getAlias())));
        } else {
          return $this->redirect($referer = $request->headers->get('referer'));
        }
    }
	
    # --------------------
    # Одобрение объявлений
    # --------------------
    public function moderedsAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
		$query = @$request->request->all()["advs_m"];
		
		if($query) foreach($query as $id=>$status) {
		
			$adv = AdvsQuery::create()->findOneById($id);

			if (!$adv) {
				throw $this->createNotFoundException(
					'Объявление не существует'
				);
			}
			
			if (!$adv->getModerApproved()) {

				$name = $adv->getName();	
				
				$adv_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $adv->getUserId()));      
				
				// Автоматическая публикация в Твиттер
				$this->twitterPost($adv);              
				// Автоматическая публикация в VK
				$this->vkPostOnWall($adv);
				
				$sum = 50;				
				$account = UserAccountQuery::create()->findOneByFosUserId($adv->getUserId()); 
				if ($account){
					$account->setBalance($account->getBalance() + $sum);
					$account->save();
					$transaction = new Transactions();
					$transaction->setEmail('bonus@megabob.ru');
					$transaction->setSum($sum);
					$transaction->setFosUserId($adv->getUserId());
					$transaction->setType('Бонус за объявление');
					$transaction->setTransactionDate(date("Y-m-d H:i:s"));
					$transaction->save();
				}

				$adv->setSocialDate(strtotime( "-2 days", strtotime( date("Y-m-d H:i:s") ) ));                
				$adv->setModerApproved(TRUE);
				$adv->save();
				
				$packet = $adv->getAdvPacketss();
				if ($packet[0]->getPaid() == 1) {
					$packet[0]->setUseBefore(strtotime( "+".$packet[0]->getPackets()->getDays()." days", strtotime( date("Y-m-d H:i:s") ) ) );
					$packet[0]->save();
				}							   
								
				$moder_stat = new AdvsModerStat();
				$moder_stat->setModerId($user->getId());
				$moder_stat->setAdvId($adv->getId());
				$moder_stat->setOperation('Одобрение');
				$moder_stat->save();
			}
		}
		
		$this->get('session')->getFlashBag()->add(
			'noticesite',
			'Объявления успешно одобрены!'
		);
        
        return $this->redirect($referer = $request->headers->get('referer'));
    }
    
    # --------------------
    # Отклонение объявлений
    # --------------------
    public function disabledsAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
		$query = @$request->request->all()["advs_m"];
		
		if($query) foreach($query as $id=>$status) {
		
			$adv = AdvsQuery::create()->findPk($id);
			if ($adv) {				
				$adv->setEnabled(FALSE);                
				$adv->setModerApproved(FALSE);
				$adv->save();
        /*
        # Отсылаем сообщение пользователю, если объявление было выключено.
        $adv_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $adv->getUserId()));
        $subject = 'Ваше объявление на MegaBob.ru';
        $from = 'MegaBob.ru <noreply@megabob.ru>';
        $to = $adv_user->getEmail();
        $body = $this->renderView(
            'AdminAdminBundle:Advs:email.txt.twig',
            array('email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advid' => $adv->getId(), 'advname' => $adv->getName())
        );
        if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) {        
        # увеличиваем счетчик кол-ва отправленных писем
        $email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
        $adv_user->setEmailSendCnt($email_cnt+1);
        $adv_user->save();
				*/				
				$moder_stat = new AdvsModerStat();
				$moder_stat->setModerId($user->getId());
				$moder_stat->setAdvId($adv->getId());
				$moder_stat->setOperation('Отклонение');
				$moder_stat->save();
			}
		}
		
		$this->get('session')->getFlashBag()->add(
			'noticesite',
			'Объявления успешно отклонены!'
		);        
      return $this->redirect($referer = $request->headers->get('referer'));
    }
	
    # ---------------------
    # Объявление в дайджест
    # ---------------------
    public function digestAction($id, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
		$adv = AdvsQuery::create()->findOneById($id);

        if (!$adv) {
            throw $this->createNotFoundException(
                'Объявление не существует'
            );
        }        

		$adv->setDigest(TRUE);
        $adv->save();
        // Автоматическая публикация в Telegram
        //$this->telegramPost($adv);

        $this->get('session')->getFlashBag()->add(
            'noticesite',
            'Объявление №'.$id.' "'.$adv->getName().'" успешно отправлено в дайджест!'
        );
		
		$moder_stat = new AdvsModerStat();
		$moder_stat->setModerId($user->getId());
		$moder_stat->setAdvId($adv->getId());
		$moder_stat->setOperation('В дайджест');
		$moder_stat->save();
        
        return $this->redirect($referer = $request->headers->get('referer'));
    }
    
    # ---------------------
    # Выключение объявления
    # ---------------------
    public function offAction($id, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
		$adv = AdvsQuery::create()->findOneById($id);

        if (!$adv) {
            throw $this->createNotFoundException(
                'Объявление не существует'
            );
        }        

        $name = $adv->getName();
        
        $adv->setModerApproved(FALSE);
        $adv->setEnabled(FALSE);
        $adv->save();
        
        $top_panel = array();
        $top_panel['settings'] = SettingsQuery::create()->findOne();
        
        # Отсылаем сообщение пользователю, если объявление было выключено.
        $adv_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $adv->getUserId()));
        $subject = 'Ваше объявление на '.$top_panel['settings']->getName();
        $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
        $to = $adv_user->getEmail();
        $body = $this->renderView(
            'AdminAdminBundle:Advs:email.txt.twig',
            array('top_panel' => $top_panel, 'email' => $adv_user->getEmail(), 'username' => $adv_user->getRealname(), 'advs' => [$adv])
        );
        if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) {
			$this->get('session')->getFlashBag()->add('noticesite','Письмо о нарушении правил успешно отправлено');
			# увеличиваем счетчик кол-ва отправленных писем
			$email_cnt = $adv_user->getEmailSendCnt()?$adv_user->getEmailSendCnt():0;
			$adv_user->setEmailSendCnt($email_cnt+1);
			$adv_user->save();
		} 

        $this->get('session')->getFlashBag()->add(
            'noticesite',
            'Объявление №'.$id.' "'.$adv->getName().'" успешно выключено!'
        );
		
		$moder_stat = new AdvsModerStat();
		$moder_stat->setModerId($user->getId());
		$moder_stat->setAdvId($adv->getId());
		$moder_stat->setOperation('Выключение');
		$moder_stat->save();

        return $this->redirect($referer = $request->headers->get('referer'));
    }
    
    # -------------------
    # Удаление объявления
    # -------------------
    public function deleteAction($id)
    {
        $adv = AdvsQuery::create()->findOneById($id);

        if (!$adv) {
            throw $this->createNotFoundException(
                'Объявление не существует'
            );
        }
		
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
                echo "Ошибка удаления изображения ".$e->getPath();
            }
          }
          if ($MediumThumbname) {
            try {                  
                $fs->remove( $dir.'/'.$MediumThumbname ); 
            } catch (IOExceptionInterface $e) {
                echo "Ошибка удаления изображения ".$e->getPath();
            }
          }
          if ($Filename) {
            try {                       
                $fs->remove( $dir.'/'.$Filename );
            } catch (IOExceptionInterface $e) {
                echo "Ошибка удаления изображения ".$e->getPath();
            }
          }
        }
        
        $adv->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Объявление №'.$id.' "'.$name.'" успешно удалено!'
        );

        return $this->redirect($this->generateUrl('admin_admin_advspage'));
    }

    # -------------------
    # Удаление жалобы
    # -------------------
    public function deleteComplaineAction($id, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
		
		$complaine = AdvComplaineQuery::create()
            ->filterById($id)
            ->findOne();

        $moder_stat = new AdvsModerStat();
		$moder_stat->setModerId($user->getId());
		$moder_stat->setAdvId($complaine->getAdvId());
		$moder_stat->setOperation('Удаление жалобы');
		$moder_stat->save();
		
		$complaine->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Жалоба успешно удалена!'
        );	

        return $this->redirect($referer = $request->headers->get('referer'));
    }

}

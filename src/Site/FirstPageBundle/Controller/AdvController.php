<?php

namespace Site\FirstPageBundle\Controller;

use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\UserAccount;
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Model\PacketsQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvPrice;
use Admin\AdminBundle\Model\UserAccountQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\TransactionsQuery;
use Admin\AdminBundle\Form\AdvType;
use Admin\AdminBundle\Controller\Image;
use Admin\AdminBundle\Form\AdvEditType;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Site\FirstPageBundle\Controller\Qiwi;
use Site\FirstPageBundle\Controller\Qconst;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Admin\AdminBundle\Model\Shops;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Form\ShopsType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class AdvController extends Controller
{

  #########################
  # Добавление объявления #
  #########################

  public function addAction($alias, Request $request)
  {
    //if($alias) $this->redirect($this->generateUrl('add_adv_page'));
    #---- Единая конфигурация -------------------------------------------------------	
    
    # GET-запросы
    $this->get('get_params')->build($request);
    
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_bottom = $this->get('banner')->select($zone = 5, $request);

    # Формируем верхнюю панель
    $top_panel = $this->get('toppanel')->buildPanel($request);

    $session = $request->getSession();
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    elseif (null !== $session && $session->has(SecurityContext::
      AUTHENTICATION_ERROR))
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = '';
    }
    if ($error)
    {
      $error = $error->getMessage();
    }
    $lastUsername = (null === $session) ? '':
    $session->get(SecurityContext::LAST_USERNAME);
    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    $search_form = $this->createForm(new SimpleSearchType());

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $menu = MenuQuery::create()->find();

    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    # ------------------------------------------------------------------------------------

    $_SESSION['adv_temp_id'] = @$_SESSION['adv_temp_id'] ? $_SESSION['adv_temp_id'] :
      uniqid();

    $adv = new Advs();

    # Вставляем в объявление ID пользователя
    if ($user != 'anon.')
    {
      $adv->username = $user->getRealname();
      $adv->setEmail($user->getEmail());
      $adv->setPhone($user->getPhone());
      $adv->setUserId($user->getId());
      $adv->setSkype($user->getSkype());
    }
	
    if (@$alias) {
      $cat_select = AdCategoriesQuery::create()->findOneByAlias($alias);
      if ($cat_select) {
        $adv->setCategoryId($cat_select->getId());
      }
    }

    # Выбираем действующие пакеты
    $packets = PacketsQuery::create()->orderById()->find();

    $form = $this->createForm(new AdvType(), $adv);

    $form->handleRequest($request);

    $images = AdvImagesQuery::create()->orderById()->findByTempId($_SESSION['adv_temp_id']);

    # Определяем дополнительные поля
    $category_fields_array = array();
    $category = AdCategoriesQuery::create()->findPk($adv->getCategoryId());

    if ($category)
    {
      $category_fields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($category->
          getParentId(), $adv->getCategoryId()))->orderByType()->orderByName()->findByArray(array('deleted' => false,
          'enabled' => true));
      foreach ($category_fields as $category_field)
      {
        $category_fields_array[] = 'params_' . $category_field->getId();
      }
    }

    $dispatcher = $this->container->get('event_dispatcher');

    if ($adv->getEnabled() && $form->isValid())
    {

      $alert = 0;
      $adv_errors = array();
      $request_data = $request->request->all();
      if (@$request_data['advs']['email'] && @$request_data['advs']['password'])
      {
        $user = UserQuery::create()->filterByEmail($request_data['advs']['email'])->
          findOne();
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        if ($encoder->isPasswordValid($user->getPassword(), $request_data['advs']['password'],
          $user->getSalt()))
        {
          if ($user->getLocked()) {
            $this->get('session')->getFlashBag()->add('alertsite','Ваша учетная запись заблокирована!');
            $url = $this->container->get('router')->generate('fos_user_security_login');
            $response = new RedirectResponse($url);
            return $response;
          } else {
            $adv->username = $user->getRealname();
            $adv->email = $user->getEmail();
            $adv->setPhone($user->getPhone());
            $adv->setUserId($user->getId());
            $adv->setSkype($user->getSkype());
          }		  
        }
        else
        {
          $this->get('session')->getFlashBag()->add('alertsite',
            'Неверный пароль пользователя. Авторизуйтесь чтобы подать объявление заново.');
          $url = $this->container->get('router')->generate('fos_user_security_login');
          $response = new RedirectResponse($url);
          return $response;
        }
      }

      $adv->setModerApproved(false);
      $adv->setPublishDate(date("Y-m-d H:i:s"));
      $adv->setUpDate(date("Y-m-d H:i:s"));
      $adv->setPublishBeforeDate(strtotime("+90 days", strtotime(date("Y-m-d H:i:s"))));

      # При необходимости генерируем Название
      if ($adv->getName()=='generator') {
        if ($category->getGenerator()) {
          $generator = $category->getGenerator();
          preg_match_all("/{(\d+)}/ix", $generator, $out, PREG_PATTERN_ORDER);
          foreach ($out[1] as $gvalue) {
            $new_value = null;
            $gid = intval($gvalue);
            $gfield = AdCategoriesFieldsQuery::create()->findOneById($gid);
            if ($adv->{'params_' . $gid}) {
              if ($gfield->getType() == 2 || $gfield->getType() == 6 || $gfield->getType() == 7 || $gfield->getType() == 8) {
                $ggvalue = AdCategoriesFieldsValuesQuery::create()->filterById($adv->{'params_' .
                  $gid})->findOne();
                if ($ggvalue) {
                  $new_value = $ggvalue->getName();
                } else {
                  $new_value = $adv->{'params_' . $gid};
                }
              } else {
                $new_value = $adv->{'params_' . $gid};
              }
            }
            $gpattern = "/{" . $gvalue . "\}/ix";
            if ($new_value) {
              $generator = preg_replace($gpattern, $new_value, $generator);
            } else {
              $adv->setName('');
              $alert = 1;
              $adv_errors[] = 'Выбраны не все необходимые характеристики';
            }
          }
          if (!$alert) $adv->setName($generator);
        } else {
          $adv->setName('');
          $alert = 1;
          $adv_errors[] = 'Введите название объявления!';
        }
      } else {
        # Форматирует название объявления
        $adv->setName($this->text_transform($adv->getName()));
      }

      # Форматирует текст объявления
      $adv->setDescription($this->text_transform($adv->getDescription()));
	  
	  # Форматирует адрес сайта (Добавляет в начало адреса http:// или https:// )
      if ($adv->getSite()) {		  
		  $site = explode("http://", trim($adv->getSite()));
		  if (!@$site[1]) {			
        $site_s = explode("https://", trim($adv->getSite()));
        if (!@$site_s[1]) {
          $adv->setSite('http://'.trim($adv->getSite()));
        }
		  }
      $adv_url = $this->check_url($adv->getSite());
      if (!$adv_url) {
        $alert = 1;
				$adv_errors[] = 'Ссылка на несуществующий сайт или страницу';
      }
	  }
	  # Проверяем ссылку на видео
      if ($adv->getYoutube()) {		  
		  $video = explode("http://youtu.be/", trim($adv->getYoutube()));
		  if (@$video[1]) {
			$adv->setYoutube('https://youtu.be/'.$video[1]);
		  } else {
			$video = explode("https://youtu.be/", trim($adv->getYoutube()));
			  if (@$video[1]) {
				$adv->setYoutube('https://youtu.be/'.$video[1]);
			  } else {
				$video_s = explode("http://www.youtube.com/watch?v=", trim($adv->getYoutube()));
				if (@$video_s[1]) {
					$adv->setYoutube('https://youtu.be/'.$video_s[1]);
				} else {
					$video_s = explode("https://www.youtube.com/watch?v=", trim($adv->getYoutube()));
					if (@$video_s[1]) {
						$adv->setYoutube('https://youtu.be/'.$video_s[1]);
					} else {
						$alert = 1;
						$adv_errors[] = 'Ссылка на видео имеет неправильный формат (необходимо: https://youtu.be/... или https://www.youtube.com/watch?v=...)';
					}
				}
			  }
		  }		
	  }

    if (!$adv->getPrice()) $adv->setPrice(0);
	  
	  # Проверяем объявление на совпадения	
    if ($adv->getUserId()) {
      $user_advs = AdvsQuery::create()			
        ->filterByUserId($adv->getUserId())
        ->filterByDeleted(false)
        ->filterByRegionId($adv->getRegionId())
        ->find();		
      foreach ($user_advs as $user_adv) {           
         if ($user_adv->getId() != $adv->getId()) {
         # Проверяем название
         if ($user_adv->getName() == $adv->getName() && $alert==0) {              
          $alert = 1;
          $adv_errors[] = 'Есть полное совпадение по названию с объявлением № '.$user_adv->getId().'. Размещение повторных объявлений запрещено Правилами.';
         }
         
         # Проверяем описание на точное совпадение
         if ($user_adv->getDescription() == $adv->getDescription() && $alert==0) {             
          $alert = 1;
          $adv_errors[] = 'Есть полное совпадение по описанию с объявлением № '.$user_adv->getId().'. Размещение повторных объявлений запрещено Правилами.';
         } elseif ($alert==0) {
           # Проверяем совпадения слов в описании               
           similar_text($adv->getDescription(),$user_adv->getDescription(),$procent);			   
           if (@$procent>80) {             
            $alert = 1;
            $adv_errors[] = 'Есть более '.(int)$procent.'% совпадений слов в описании с объявлением № '.$user_adv->getId().'. Размещение повторных объявлений запрещено Правилами.';
           }			   
         }
         }
      }
    }
		
    # Проверяем город в названии
		$tags = $this->getNewFormText($adv->getRegions()->getName());    
    $str = mb_strtolower($adv->getName(), 'UTF-8');
    foreach ($tags as $tag) {
      $str_tag = mb_strtolower($tag, 'UTF-8');
      preg_match_all('/'.$str_tag.'/i', $str, $matches, PREG_SET_ORDER, 0);      
      if ($matches) {
        $alert = 1;
        $adv_errors[] = 'Удалите город из названия объявления! Название города будет добавлено автоматически';
        break;
      }
    }
    $links_n = preg_match_all("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", $adv->getName());
		
    # Проверяем ссылки в названии
		$links_n = preg_match_all("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", $adv->getName());
		if ($links_n) {             
			$alert = 1;
			$adv_errors[] = 'Удалите ссылки из названия объявления! Для этого есть отдельное поле.';
		}		  
		# Проверяем телефоны в названии
		$phones_n = preg_match_all("/([+]?\d?\d?[-(.]?\d{3}[-).]?\d{3}[-.]?\d{2}[-.]?\d{2})|([+]?\d?\d?.?\d{3}?.?\d{3}?.?\d{2}.?\d{2})|(\d{3}[-.]?\d{2}[-]?\d{2})/i",$adv->getName());
		if ($phones_n) {             
			$alert = 1;
			$adv_errors[] = 'Удалите телефонные номера из названия объявления! Для этого есть отдельное поле.';
		}
		# Проверяем ссылки в тексте
		$links = preg_match_all("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", $adv->getDescription());
		if ($links) {             
			$alert = 1;
			$adv_errors[] = 'Удалите ссылки из текста объявления! Для этого есть отдельное поле.';
		}		  
		# Проверяем телефоны в тексте
		$phones = preg_match_all("/([+]?\d?\d?[-(.]?\d{3}[-).]?\d{3}[-.]?\d{2}[-.]?\d{2})|([+]?\d?\d?.?\d{3}?.?\d{3}?.?\d{2}.?\d{2})|(\d{3}[-.]?\d{2}[-]?\d{2})/i",$adv->getDescription());
		if ($phones) {             
			$alert = 1;
			$adv_errors[] = 'Удалите телефонные номера из текста объявления! Для этого есть отдельное поле.';
		}
    # Проверяем чтобы название не было только из заглавных букв
    $Upper = mb_strtoupper($adv->getName(), 'utf-8');
    if ($adv->getName() == $Upper) {
      $alert = 1;
			$adv_errors[] = 'Название объявления не должно состоять только из заглавных букв!';
    }
    # Проверяем чтобы описание не было только из заглавных букв
    $Upper = mb_strtoupper($adv->getDescription(), 'utf-8');
    if ($adv->getDescription() == $Upper) {
      $alert = 1;
			$adv_errors[] = 'Описание объявления не должно состоять только из заглавных букв!';
    }
		
		# Сохраняем Объявление
    if ($alert) {
			$alert_message = '';
			foreach ($adv_errors as $adv_error) {
				$alert_message .= $adv_error.'<br>';
			}
			$this->get('session')->getFlashBag()->add('alertsite',$alert_message);
		} else {
      # Если пользователь не зарегистрирован, регистрируем его как нового
      if ($user == 'anon.')
      {
        $userpassword = uniqid();
        $userManager = $this->get('fos_user.user_manager');
        $newuser = $userManager->createUser();
        $newuser->setEnabled(true);
        $newuser->setUsername($request_data['advs']['email']);
        $newuser->setUsernameCanonical($request_data['advs']['email']);
        $newuser->setEmail($request_data['advs']['email']);
        $newuser->setEmailCanonical($request_data['advs']['email']);
        $newuser->setRealname($request_data['advs']['username']);
        $newuser->setPhone($request_data['advs']['phone']);
        $newuser->setSkype($request_data['advs']['skype']);
        $newuser->setPlainPassword($userpassword);
        $newuser->setCreateDate(date("Y-m-d H:i:s"));
        $newuser->setEmailToken(md5(uniqid()));
        $newuser->setPhoneCode(rand(111111, 999999));
        $tokenGenerator = $this->container->get('fos_user.util.token_generator');        
        $newuser->setConfirmationToken($tokenGenerator->generateToken());
        $userManager->updateUser($newuser);
        $user = $newuser;
        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
        $this->get('session')->getFlashBag()->add('noticesite', 'Пользователь ' . $newuser->
          getUsername() . ' успешно зарегистрирован! Логин: <strong>' . $newuser->getEmail() .
          '</strong> Пароль: <strong>' . $userpassword . '</strong>.<br>Вам отправлено письмо с регистрационными данными и ссылкой на подтверждение Email.');
        if (null === $response = $event->getResponse())
        {
          $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
          $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new
          FilterUserResponseEvent($newuser, $request, $response));

        $user_account = new UserAccount();
        $user_account->setFosUserId($newuser->getId());        
        $user_account->save();        

        # Отправляем пользователю письмо о регистрации
        $subject = 'Добро пожаловать на '.$top_panel['settings']->getName();
        $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
        $to = $newuser->getEmail();
        $body = $this->renderView('SiteFirstPageBundle:Adv:email.txt.twig', array(
          'top_panel' => $top_panel, 
          'user'    => $newuser,
          'username' => $newuser->getUsername(),
          'realname' => $newuser->getRealname(),
          'email' => $newuser->getEmail(),
          'email_token' => $newuser->getEmailToken(),
          'password' => $userpassword));
        $this->get('mail_helper')->sendMailing($from, $to, $subject, $body);

        $adv->setUserId($newuser->getId());
        $adv->setShopId(null);
      }

      # Форматируем номер телефона
      $adv->setPhone($this->format_phone($adv->getPhone()));
      
		  $adv->setAlias($this->str2url($adv->getName()));
		  $adv->save();

		  # Присваиваем изображениям ID объявления
		  foreach (@$images as $image)
		  {
			$image->setAdvId($adv->getId());
			$image->setTempId(0);
			$image->save();

			$dir = 'images/a/images';

			# Создаем миниатюру 140*100
			$image_new = new Image($dir . '/' . $image->getPath());
			$image_new->thumbnail_full(140, 100);
			$image_new->save($dir . '/' . $image->getThumb());

			# Создаем миниатюру 300*225
			$image_new = new Image($dir . '/' . $image->getPath());
			$image_new->thumbnail_full(300, 225);
			$image_new->save($dir . '/' . $image->getMediumThumb());

			# Изменяем изображение до 800*600 и накладываем водяной знак bundles/sitefirstpage/images/watermark.png
			$image_new = new Image($dir . '/' . $image->getPath());
			$image_original_info = $image_new->get_original_info();
			if ($image_original_info['width'] > 800 || $image_original_info['height'] > 600) 
				$image_new->best_fit(800, 600);
			$image_new->overlay('bundles/sitefirstpage/images/watermark.png', 'bottom right',
			  .9, -5, -5);
			$image_new->save($dir . '/' . $image->getPath());
			unset($image_new);

		  }

		  # Заполняем Дополнительные поля категории и сохраняем
		  foreach ($category_fields as $category_field)
		  {
			$adv_params = new AdvParams();
			$adv_params->setAdvId($adv->getId());
			$adv_params->setFieldId($category_field->getId());
			if ($category_field->getType() == 2 || $category_field->getType() == 6 || $category_field->
			  getType() == 7 || $category_field->getType() == 8 )
			{
			  $adv_params->setValueId($adv->{'params_' . $category_field->getId()});
			  $adv_params->setTextValue(null);
			}
			else
			{
			  $adv_params->setTextValue($adv->{'params_' . $category_field->getId()});
			  $adv_params->setValueId(null);
			}
			$adv_params->save();
		  }

		  # Сохраняем выбранный пакет услуг
		  $packet_id = $request->request->get('packet');
		  $packet = new AdvPackets();
		  $packet->setAdvId($adv->getId());
		  $packet->setPacketId($packet_id);
		  $packet->setEnabled(true);
		  if ($packet_id == 3)
		  {
			$packet->setPaid(true);
			$packet->setPaidDate(date("Y-m-d H:i:s"));
		  }
		  $packet->save();

		  $this->get('session')->getFlashBag()->add('noticesite', 'Объявление № ' . $adv->
			getId() . ' "' . $adv->getName() .
			'" успешно добавлено!');
		  return @$response ? $response : $this->redirect($this->generateUrl('site_adv_page',array(
        'category'=>$adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(),
        'subcategory'=>$adv->getAdCategories()->getAlias(),
        'region'=>$adv->getRegions()->getAlias(),
        'id'=>$adv->getId(),
        'alias'=>$adv->getAlias())));
		}
	}

    if (!$form->isValid())
    {
      $errors = $this->getAllFormErrorMessages($form);
      $errorq = '';
      foreach ($errors as $one_error)
      {
        $this->get('session')->getFlashBag()->add('alertsite', (is_array($one_error) ? $one_error['message'] :
          $one_error));
      }
    }
    if (!$adv->getEnabled())
    {
      $errors = $this->getAllFormErrorMessages($form);
      $errorq = '';
      foreach ($errors as $one_error)
      {
        $this->get('session')->getFlashBag()->add('alertsite',
          'Вы не согласились с правилами сайта');
      }
    }
    
    $response = new Response();	
    $response->headers->addCacheControlDirective('no-store', true);
    $response->headers->addCacheControlDirective('no-cache', true);
    $response->headers->addCacheControlDirective('must-revalidate', true);
    $response->headers->addCacheControlDirective('post-check', 0);
    $response->headers->addCacheControlDirective('pre-check', 0);
    $date = new \DateTime();
    $date->modify('-90 day');
    $response->setLastModified($date);
    $response->setMaxAge(3600);

    return $this->render('SiteFirstPageBundle:Adv:add.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'banner_search' => $banner_search,
      'banner_bottom' => $banner_bottom,
      'images' => $images,
      'category_fileds_array' => $category_fields_array,
      'packets' => $packets,
      'csrf_token' => $csrfToken,      
      'filt' => $filt,
      'top_panel' => $top_panel,
      'search_form' => $search_form->createView(),
      'form' => $form->createView(),
      'user' => $user,
      'menu' => $menu,
      'cat_select' => @$cat_select?:NULL,
      'image_error' => null),$response);
  }

  protected function getAllFormErrorMessages($form)
  {
    $retval = array();
    foreach ($form->getErrors() as $key => $error)
    {      
	  if ($error->getMessagePluralization() !== null)
      {
        $retval['message'] = $this->get('translator')->transChoice($error->getMessage(),
          $error->getMessagePluralization(), $error->getMessageParameters(), 'validators');		  
      }
      else
      {
        $retval['message'] = $this->get('translator')->trans($error->getMessage(), array
          (), 'validators');		  
      }
    }
    foreach ($form->all() as $name => $child)
    {
      $errors = $this->getAllFormErrorMessages($child);
      if (!empty($errors))
      {
        $retval[$name] = $errors;
      }
    }
    return $retval;
  }
  
  public function addUpdateAction(Request $request)
  {
    
    $session = $request->getSession();
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    elseif (null !== $session && $session->has(SecurityContext::
      AUTHENTICATION_ERROR))
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = '';
    }
    if ($error)
    {
      $error = $error->getMessage();
    }
    $lastUsername = (null === $session) ? '':
    $session->get(SecurityContext::LAST_USERNAME);
    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    # ------------------------------------------------------------------------------------

    $_SESSION['adv_temp_id'] = @$_SESSION['adv_temp_id'] ? $_SESSION['adv_temp_id'] :
      uniqid();

    $adv = new Advs();

    # Выбираем действующие пакеты
    $packets = PacketsQuery::create()->orderById()->find();

    $form = $this->createForm(new AdvType(), $adv);

    $form->handleRequest($request);

    $images = AdvImagesQuery::create()->orderById()->findByTempId($_SESSION['adv_temp_id']);

    # Определяем дополнительные поля
    $category_fields_array = array();
    $category = AdCategoriesQuery::create()->findPk($adv->getCategoryId());

    if ($category)
    {
      $category_fields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($category->
          getParentId(), $adv->getCategoryId()))->orderByType()->orderByName()->findByArray(array('deleted' => false,
          'enabled' => true));
      foreach ($category_fields as $category_field)
      {
        $category_fields_array[] = 'params_' . $category_field->getId();
      }
    }
    
    $response = new Response();

    return $this->render('SiteFirstPageBundle:Adv:add_update.html.twig', array(      
      'images' => $images,
      'category_fileds_array' => $category_fields_array,
      'packets' => $packets,
      'csrf_token' => $csrfToken,      
      'form' => $form->createView(),      
      'cat_select' => @$cat_select?:NULL,
      'image_error' => null),$response);
  }

  #############################
  # Редактирование объявления #
  #############################

  public function editAction($id, Request $request)
  {
    #---- Единая конфигурация -------------------------------------------------------

    # GET-запросы
    $this->get('get_params')->build($request);

    # Формируем верхнюю панель
    $top_panel = $this->get('toppanel')->buildPanel($request);

    $session = $request->getSession();
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    elseif (null !== $session && $session->has(SecurityContext::
      AUTHENTICATION_ERROR))
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = '';
    }
    if ($error)
    {
      $error = $error->getMessage();
    }
    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::
      LAST_USERNAME);
    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    $search_form = $this->createForm(new SimpleSearchType());

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $menu = MenuQuery::create()->find();

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    # ------------------------------------------------------------------------------------

    $_SESSION['adv_temp_id'] = @$_SESSION['adv_temp_id'] ? $_SESSION['adv_temp_id'] :
      uniqid();

    $adv = AdvsQuery::create()->findOneById($id);

    if (!$adv)
    {
      throw $this->createNotFoundException('Объявление не существует');
    }

    if ($user == 'anon.' || ($user->getId() != $adv->getUserId() && $user->getRoles()[1] !=
      'ROLE_SUPER_ADMIN'))
    {
      throw new AccessDeniedException('У вас нет доступа к данной странице.');
    }
	
	$price = $adv->getPrice();

    # Заполняем Дополнительные поля категорий
    $category = AdCategoriesQuery::create()->findPk($adv->getCategoryId());
    $category_fields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($category->
        getParentId(), $adv->getCategoryId()))->findByArray(array('deleted' => false,
        'enabled' => true));

    foreach ($category_fields as $category_field)
    {
      $adv_param = AdvParamsQuery::create()->findOneByArray(array('advId' => $id,
          'fieldId' => $category_field->getId()));

      if ($adv_param)
      {
        if ($category_field->getType() == 2 || $category_field->getType() == 6 || $category_field->
          getType() == 7 || $category_field->getType() == 8)
        {
          $adv->{'params_' . $category_field->getId()} = @$adv_param->getValueId();
        }
        else
        {
          $adv->{'params_' . $category_field->getId()} = @$adv_param->getTextValue();
        }
      }
      else
      {
        $adv->{'params_' . $category_field->getId()} = null;
      }
    }

    $form = $this->createForm(new AdvEditType(), $adv);

    $form->handleRequest($request);

    $images = AdvImagesQuery::create()->where('adv_id =' . $id)->_or()->where("temp_id ='" .
      $_SESSION['adv_temp_id'] . "'")->find();

    $post_request = $request->request->all();
    
    if ($form->isValid() && $post_request['advs']['enabledd'])
    {

      # При необходимости генерируем Название
      if ($category->getGenerator()) {
        $generator = $category->getGenerator();
        preg_match_all("/{(\d+)}/ix", $generator, $out, PREG_PATTERN_ORDER);
        foreach ($out[1] as $gvalue) {
          $new_value = null;
          $gid = intval($gvalue);
          $gfield = AdCategoriesFieldsQuery::create()->findOneById($gid);
          if ($adv->{'params_' . $gid}) {
            if ($gfield->getType() == 2 || $gfield->getType() == 6 || $gfield->getType() == 7 || $gfield->getType() == 8) {
              $ggvalue = AdCategoriesFieldsValuesQuery::create()->filterById($adv->{'params_' .
                $gid})->findOne();
              if ($ggvalue) {
                $new_value = $ggvalue->getName();
              } else {
                $new_value = $adv->{'params_' . $gid};
              }
            } else {
              $new_value = $adv->{'params_' . $gid};
            }
          }
          $gpattern = "/{" . $gvalue . "\}/ix";
          if ($new_value) {
            $alert = 0;
			$generator = preg_replace($gpattern, $new_value, $generator);
          } else {
            $alert = 1;            
          }
        }
        if (!$alert) $adv->setName($generator);
      } else {
        # Форматирует название объявления
        $adv->setName($this->text_transform($adv->getName()));
      }    

      # Сохраняем Объявление
      if (@$user->getRoles()[1] != 'ROLE_SUPER_ADMIN') {
        $adv->setModerApproved(false);
        if ($price != $adv->getPrice()) {
          $modify = new AdvPrice();
          $modify->setAdvId($adv->getId());
          $modify->setPriceOld($price);
          $modify->setPriceNew($adv->getPrice());
          $modify->save();
        }
      }
        
      # Форматирует текст объявления
      $adv->setDescription($this->text_transform($adv->getDescription()));
      
      # Форматирует адрес сайта (Добавляет в начало адреса http:// или https:// )
      if ($adv->getSite()) {		  
        $site = explode("http://", trim($adv->getSite()));
        if (!@$site[1]) {			
          $site_s = explode("https://", trim($adv->getSite()));
          if (!@$site_s[1]) {
            $adv->setSite('http://'.trim($adv->getSite()));
          }
        }
        $adv_url = $this->check_url($adv->getSite());
        if (!$adv_url) {
          $adv->setSite(null);
        }        
      }
      
      # Проверяем ссылку на видео
      if ($adv->getYoutube()) {		  
		  $video = explode("http://youtu.be/", trim($adv->getYoutube()));
		  if (@$video[1]) {
			$adv->setYoutube('https://youtu.be/'.$video[1]);
		  } else {
			$video = explode("https://youtu.be/", trim($adv->getYoutube()));
			  if (@$video[1]) {
				$adv->setYoutube('https://youtu.be/'.$video[1]);
			  } else {
				$video_s = explode("http://www.youtube.com/watch?v=", trim($adv->getYoutube()));
				if (@$video_s[1]) {
					$adv->setYoutube('https://youtu.be/'.$video_s[1]);
				} else {
					$video_s = explode("https://www.youtube.com/watch?v=", trim($adv->getYoutube()));
					if (@$video_s[1]) {
						$adv->setYoutube('https://youtu.be/'.$video_s[1]);
					} else {
						$alert = 1;
						$adv_errors[] = 'Ссылка на видео имеет неправильный формат (необходимо: https://youtu.be/... или https://www.youtube.com/watch?v=...)';
					}
				}
			  }
		  }		
	  }
      
      # Форматируем номер телефона
      $adv->setPhone($this->format_phone($adv->getPhone()));
      
      $adv->save();

      # Присваиваем изображениям ID объявления
      foreach (@$images as $image)
      {
        if (!$image->getAdvId())
        {
          $image->setAdvId($adv->getId());
          $image->setTempId(0);
          $image->save();

          $dir = 'images/a/images';

          # Создаем миниатюру 140*100
          $image_new = new Image($dir . '/' . $image->getPath());
          $image_new->thumbnail_full(140, 100);
          $image_new->save($dir . '/' . $image->getThumb());

          # Создаем миниатюру 300*225
          $image_new = new Image($dir . '/' . $image->getPath());
          $image_new->thumbnail_full(300, 225);
          $image_new->save($dir . '/' . $image->getMediumThumb());

          # Изменяем изображение до 800*600 и накладываем водяной знак bundles/sitefirstpage/images/watermark.png
          $image_new = new Image($dir . '/' . $image->getPath());
          $image_original_info = $image_new->get_original_info();
          if ($image_original_info['width'] > 800 || $image_original_info['height'] > 600) 
              $image_new->best_fit(800, 600);
          $image_new->overlay('bundles/sitefirstpage/images/watermark.png', 'bottom right',
            .9, -5, -5);
          $image_new->save($dir . '/' . $image->getPath());
          unset($image_new);
        }
      }

      # Заполняем Дополнительные поля категории и сохраняем
      $category_fields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($category->
          getParentId(), $adv->getCategoryId()))->findByArray(array('deleted' => 0,
          'enabled' => 1));
      foreach ($category_fields as $category_field)
      {
        $adv_params = AdvParamsQuery::create()->filterByAdvId($adv->getId())->
          findOneByFieldId($category_field->getId());
        if (!$adv_params)
        {
          $adv_params = new AdvParams();
        }
        $adv_params->setAdvId($adv->getId());
        $adv_params->setFieldId($category_field->getId());
        if ($category_field->getType() == 2 || $category_field->getType() == 6 || $category_field->
          getType() == 7 || $category_field->getType() == 8)
        {
          $adv_params->setValueId($adv->{'params_' . $category_field->getId()});
          $adv_params->setTextValue(null);
        }
        else
        {
          $adv_params->setTextValue($adv->{'params_' . $category_field->getId()});
          $adv_params->setValueId(null);
        }
        $adv_params->save();
      }

      $this->get('session')->getFlashBag()->add('noticesite', 'Объявление №' . $adv->
        getId() . ' "' . $adv->getName() . '" успешно сохранено!' . ((@$user->getRoles()[1] !=
        'ROLE_SUPER_ADMIN') ? ' Теперь его снова должен проверить модератор.' : ''));
      return $this->redirect($this->generateUrl('user_advs_page'));
    }

    return $this->render('SiteFirstPageBundle:Adv:edit.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'images' => $images,
      'csrf_token' => $csrfToken,
      'banner_top' => null,
      'banner_search' => null,
      'banner_advs' => null,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'search_form' => $search_form->createView(),
      'form' => $form->createView(),
      'user' => $user,
      'menu' => $menu));
  }

  #############################
  #    Включение объявления   #
  #############################

  public function onAction($id, Request $request)
  {

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    # ------------------------------------------------------------------------------------

    $adv = AdvsQuery::create()->findOneById($id);
    if (!$adv)
    {
      throw $this->createNotFoundException('Объявление не существует');
    }

    if ($adv->getUserId() == $user->getId())
    {
      $adv->setPublishDate(date("Y-m-d H:i:s"));
      $adv->setPublishBeforeDate(strtotime("+90 days", strtotime(date("Y-m-d H:i:s"))));
      $adv->setEnabled(true);
	  $adv->setDeleted(false);
      $adv->save();

      $this->get('session')->getFlashBag()->add('noticesite', 'Объявление №' . $adv->
        getId() . ' "' . $adv->getName() . '" успешно включено!');
    }
    else
    {
      $this->get('session')->getFlashBag()->add('alertsite',
        'Вы не являетесь владельцем этого объявления!');
    }

    return $this->redirect($this->generateUrl('user_advs_page'));

  }

  #############################
  #   Обновление объявления   #
  #############################

  public function updateAction($id, Request $request)
  {

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    # ------------------------------------------------------------------------------------

    $adv = AdvsQuery::create()->findOneById($id);
    if (!$adv)
    {
      throw $this->createNotFoundException('Объявление не существует');
    }

    if ($adv->getUserId() == $user->getId())
    {
      $adv->setPublishDate(date("Y-m-d H:i:s"));
      $adv->setPublishBeforeDate(strtotime("+90 days", strtotime(date("Y-m-d H:i:s"))));
      $adv->save();

      $this->get('session')->getFlashBag()->add('noticesite', 'Объявление №' . $adv->
        getId() . ' "' . $adv->getName() . '" успешно обновлено!');
    }
    else
    {
      $this->get('session')->getFlashBag()->add('alertsite',
        'Вы не являетесь владельцем этого объявления!');
    }

    return $this->redirect($this->generateUrl('user_advs_page'));

  }

  ###############################
  #    Выключение объявления    #
  ###############################

  public function offAction($id, Request $request)
  {

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    # ------------------------------------------------------------------------------------

    $adv = AdvsQuery::create()->findOneById($id);
    if (!$adv)
    {
      throw $this->createNotFoundException('Объявление не существует');
    }

    if ($adv->getUserId() == $user->getId())
    {
      $adv->setEnabled(false);
      $adv->setPublishBeforeDate(date("Y-m-d H:i:s"));
      $adv->save();

      $this->get('session')->getFlashBag()->add('noticesite', 'Объявление №' . $adv->
        getId() . ' "' . $adv->getName() . '" успешно отключено!');
    }
    else
    {
      $this->get('session')->getFlashBag()->add('alertsite',
        'Вы не являетесь владельцем этого объявления!');
    }

    return $this->redirect($this->generateUrl('user_advs_page'));

  }

  #############################
  #    Удаление объявления    #
  #############################

  public function deleteAction($id, Request $request)
  {

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    # ------------------------------------------------------------------------------------

    $adv = AdvsQuery::create()->findOneById($id);
    if (!$adv)
    {
      throw $this->createNotFoundException('Объявление не существует');
    }

    if ($adv->getUserId() == $user->getId())
    {
      $name = $adv->getName();
      $adv->setModerApproved(false);
      $adv->setEnabled(false);
      $adv->setPublishBeforeDate(date("Y-m-d H:i:s"));
      $adv->setDeleted(true);
      $adv->save();

      $this->get('session')->getFlashBag()->add('noticesite', 'Объявление №' . $id .
        ' "' . $name . '" успешно помещено в архив!');
    }
    else
    {
      $this->get('session')->getFlashBag()->add('alertsite',
        'Вы не являетесь владельцем этого объявления!');
    }

    return $this->redirect($this->generateUrl('user_advs_page'));

  }
  
  #####################################
  #    Удаление объявления навсегда   #
  #####################################

  public function deleteForeverAction($id, Request $request)
  {

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    # ------------------------------------------------------------------------------------

    $adv = AdvsQuery::create()->findOneById($id);
    if (!$adv)
    {
      throw $this->createNotFoundException('Объявление не существует');
    }

    if ($adv->getUserId() == $user->getId())
    {
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

      $this->get('session')->getFlashBag()->add('noticesite', 'Объявление №' . $id .
        ' "' . $name . '" успешно удалено!');
    }
    else
    {
      $this->get('session')->getFlashBag()->add('alertsite',
        'Вы не являетесь владельцем этого объявления!');
    }

    return $this->redirect($this->generateUrl('user_advs_page'));

  }

  #############################
  #    Пополнение баланса     #
  #############################

  public function fillAccountAction(Request $request)
  {

    # ---- Данные пользователя ----
    $email = $request->request->get('label');
    $sum = $request->request->get('withdraw_amount');
    $operation_id = $request->request->get('operation_id');
    $find_transaction = TransactionsQuery::create()->filterByOperationId($operation_id)->
      findOne();
    if (!$find_transaction)
    {
      $transaction = new Transactions();
      $transaction->setEmail($email);
      $transaction->setSum($sum);

      $user = $this->container->get('fos_user.user_manager')->findUserBy(array('email' =>
          $email));
      if ($user && @$user->getId())
      {
        $transaction->setFosUserId($user->getId());
        $account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
        if ($account)
        {
          $account->setBalance($account->getBalance() + $sum + ($sum / 2));
          $account->save();
          $transaction->setType('Пополнение кошелька');
          $transaction->setOperationId($operation_id);
          $transaction->setTransactionDate(date("Y-m-d H:i:s"));
          # Бонус          
		  $transaction_bonus = new Transactions();
          $transaction_bonus->setEmail($email);
          $transaction_bonus->setFosUserId($user->getId());
          $transaction_bonus->setSum($sum / 2);
          $transaction_bonus->setType('Бонус за пополнение');
          $transaction_bonus->setTransactionDate(date("Y-m-d H:i:s"));
          $transaction_bonus->save();		  
        }

      }
      else
      {
        $transaction->setType('Ошибка');
      }
      $transaction->save();
      return new Response('OK', 200);

    }

    return new Response('FALSE', 404);

  }
  
  ##################################
  #    Пополнение баланса QIWI     #
  ##################################

  public function fillQiwiAction(Request $request)
  {

    $order = @$request->query->get('order');
    $find_transaction = TransactionsQuery::create()->filterByOperationId($order)->
      findOne();
    if (!$find_transaction)
    { 
      $Qiwi = new Qiwi();
      
      $info_result = $Qiwi->info($order);      
      if($info_result->result_code == 0) {        
        if ($info_result->bill->status == 'paid') {
          $sum = $info_result->bill->amount;
          $email = $info_result->bill->comment;
          $transaction = new Transactions();
          $transaction->setEmail($email);
          $transaction->setSum($sum);
          $user = $this->container->get('fos_user.user_manager')->findUserBy(array('email' =>$email));          
          if ($user && @$user->getId()) {
            $transaction->setFosUserId($user->getId());
            $account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
            if ($account) {
              $account->setBalance($account->getBalance() + ($sum) + ($sum / 2));
              $account->save();
              $transaction->setType('Пополнение кошелька');
              $transaction->setOperationId($order);
              $transaction->setTransactionDate(date("Y-m-d H:i:s"));                            
              $transaction->save();
			  # Бонус          
			  $transaction_bonus = new Transactions();
			  $transaction_bonus->setEmail($email);
			  $transaction_bonus->setFosUserId($user->getId());
			  $transaction_bonus->setSum($sum / 2);
			  $transaction_bonus->setType('Бонус за пополнение');
			  $transaction_bonus->setTransactionDate(date("Y-m-d H:i:s"));
			  $transaction_bonus->save();
              $this->get('session')->getFlashBag()->add('noticesite', 'Ваш кошелек успешно пополнен!');
            }
          }
        } else {
          $this->get('session')->getFlashBag()->add('alertsite', 'Этот счет еще не оплачен.');
        }
      } elseif ($info_result->result_code == 210) {
        $this->get('session')->getFlashBag()->add('alertsite', 'Неправильный номер счета!');
      }
    } else {
      $this->get('session')->getFlashBag()->add('alertsite', 'Этот счет уже был зачислен в кошелек! В случае ошибки, обратитесь к администрации сайта.');
    }
    
    return $this->redirect($this->generateUrl('user_balance_page'));
  } 

  ###################################
  #  Заявка на добавление магазина  #
  ###################################
  public function addShopAction(Request $request)
  {
    #---- Единая конфигурация -------------------------------------------------------

    # GET-запросы
    $this->get('get_params')->build($request);

    # Формируем верхнюю панель
    $top_panel = $this->get('toppanel')->buildPanel($request);

    $session = $request->getSession();
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    elseif (null !== $session && $session->has(SecurityContext::
      AUTHENTICATION_ERROR))
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = '';
    }
    if ($error)
    {
      $error = $error->getMessage();
    }
    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::
      LAST_USERNAME);
    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    $search_form = $this->createForm(new SimpleSearchType());

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $menu = MenuQuery::create()->find();

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    # ------------------------------------------------------------------------------------

    $shop = new Shops();
    if ($user != 'anon.') {
      $shop->setFosUserId($user->getId());
      $shop->setPhone($user->getPhone());
    }
    $request_data = $request->request->all();    
    if (@$request_data['shops']['area_id']) {
      $shop->area_id = $request_data['shops']['area_id'];
    }

    $form = $this->createForm(new ShopsType(), $shop);
    $form->handleRequest($request);
    
    if ($form['enabledd']->getData() && $form->isValid())
    {
      
      $newalias = $this->str2url($shop->getName()); 
      // Проверяем алиас на уникальность
      $alias_unique = ShopsQuery::create()->filterByAlias($newalias)->findOne();
      if ($alias_unique) $newalias = $newalias.'-'.$shop->getFosUserId();
      
      $shop->setAlias($newalias);
      
      # Форматирует адрес сайта (Добавляет в начало адреса http:// или https:// )
      if ($shop->getSite()) {		  
        $site = explode("http://", trim($shop->getSite()));
        if (!@$site[1]) {			
          $site_s = explode("https://", trim($shop->getSite()));
          if (!@$site_s[1]) {
            $shop->setSite('http://'.trim($shop->getSite()));
          }
        }		
      }
      
      $shop->save();

      if ($form['icon']->getData())
      {
        $dir = 'images/shops/images';
        $file_type = $form['icon']->getData()->getMimeType();
        switch ($file_type)
        {
          case 'image/png':
            $Filename = uniqid() . '.png';
            break;
          case 'image/jpeg':
            $Filename = uniqid() . '.jpg';
            break;
          case 'image/gif':
            $Filename = uniqid() . '.gif';
            break;
        }

        if ($Filename)
        {
          $form['icon']->getData()->move($dir, $Filename);
          $shop->setIcon($Filename);
          $shop->save();

          $image = new Image($dir . '/' . $Filename);
          $image->fit_to_width(300);
          $image->save($dir . '/' . $Filename);
        }

      }

      $this->get('session')->getFlashBag()->add('noticesite',
        'Заявка на размещение успешно отправлена. После проверки модератором ваша компания будет включена и доступна для добавления объявлений.');

      return $this->redirect($this->generateUrl('user_companies_page'));

    }

    return $this->render('SiteFirstPageBundle:Adv:add_shop.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => null,
      'banner_search' => null,
      'banner_advs' => null,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'search_form' => $search_form->createView(),
      'form' => $form->createView(),
      'user' => $user,
      'menu' => $menu));
  }
  
  ###################################
  #  Редактирование магазина        #
  ###################################
  public function editShopAction($id,Request $request)
  {
    #---- Единая конфигурация -------------------------------------------------------

    # GET-запросы
    $this->get('get_params')->build($request);

    # Формируем верхнюю панель
    $top_panel = $this->get('toppanel')->buildPanel($request);

    $session = $request->getSession();
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    elseif (null !== $session && $session->has(SecurityContext::
      AUTHENTICATION_ERROR))
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = '';
    }
    if ($error)
    {
      $error = $error->getMessage();
    }
    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::
      LAST_USERNAME);
    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    $search_form = $this->createForm(new SimpleSearchType());

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $menu = MenuQuery::create()->find();

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    # ------------------------------------------------------------------------------------

    $shop = ShopsQuery::create()->findOneById($id);
    $icon = $shop->getIcon();
    $shop->area_id = $shop->getRegions()->getAreas()->getId();
    $request_data = $request->request->all();    
    if (@$request_data['shops']['area_id']) {
      if ($request_data['shops']['area_id'] != $shop->area_id) $shop->setRegionId(NULL);
    }

    $form = $this->createForm(new ShopsType(), $shop);
    $form->handleRequest($request);
    if ($form['enabledd']->getData() && $form->isValid())
    { 

      if ($form['icon']->getData())
      {
        $dir = 'images/shops/images';
        $file_type = $form['icon']->getData()->getMimeType();
        switch ($file_type)
        {
          case 'image/png':
            $Filename = uniqid() . '.png';
            break;
          case 'image/jpeg':
            $Filename = uniqid() . '.jpg';
            break;
          case 'image/gif':
            $Filename = uniqid() . '.gif';
            break;
        }

        if ($Filename)
        {
          $form['icon']->getData()->move($dir, $Filename);
          $shop->setIcon($Filename);          

          $image = new Image($dir . '/' . $Filename);
          $image->fit_to_width(300);
          $image->save($dir . '/' . $Filename);
        }

      } else {
                $shop->setIcon($icon);
            }
            
      if(!$shop->getAlias()) {
        $newalias = $this->str2url($shop->getName());
        // Проверяем алиас на уникальность
        $alias_unique = ShopsQuery::create()->filterByAlias($newalias)->findOne();
        if ($alias_unique) $newalias = $newalias.'-'.$shop->getFosUserId();
        
        $shop->setAlias($newalias);
      }  

      # Форматирует адрес сайта (Добавляет в начало адреса http:// или https:// )
      if ($shop->getSite()) {		  
        $site = explode("http://", trim($shop->getSite()));
        if (!@$site[1]) {			
          $site_s = explode("https://", trim($shop->getSite()));
          if (!@$site_s[1]) {
            $shop->setSite('http://'.trim($shop->getSite()));
          }
        }		
      }      
      
			
      $shop->setEnabled(false);
      $shop->save();

      $this->get('session')->getFlashBag()->add('noticesite',
        'Информация о вашей компании успешно изменена. После модерации компания снова будет доступна.');

      return $this->redirect($this->generateUrl('user_companies_page'));

    }

    return $this->render('SiteFirstPageBundle:Adv:edit_shop.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => null,
      'banner_search' => null,
      'banner_advs' => null,
      'top_panel' => $top_panel,
      'filt' => $filt,
	  'company' => $shop,
      'search_form' => $search_form->createView(),
      'form' => $form->createView(),
      'user' => $user,
      'menu' => $menu));
  }
  
  ###########################
  #     Оплата в ТОП        #
	###########################
    public function advToTopAction(Request $request) {
        
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        if ($error) {
            $error = $error->getMessage();
        }
        
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
        
        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;        
        
        # ------------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();        
		if (!is_object($user) || !$user instanceof UserInterface) {
            //throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
          $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId()); 
          
        }                 
                    
		$request_data = $request->request->all();
		$adv = AdvsQuery::create()->findOneById($request_data['form']['id']);
		if ($request_data['form']['paid_type'] == 1) {
		  if ($request_data['form']['sum'] <= $user->account->getBalance()) {
			$transaction = new Transactions();
			$transaction->setEmail($user->getEmail());
			$transaction->setFosUserId($user->getId());
			$transaction->setSum($request_data['form']['sum']);
			$transaction->setType('Оплата поднятия в ТОП для объявления №'.$adv->getId());
			$transaction->setTransactionDate(date("Y-m-d H:i:s"));
			$transaction->save();
			$adv->setUpDate(date("Y-m-d H:i:s") );
			$adv->save();
			$user->account->setBalance($user->account->getBalance()-$request_data['form']['sum']);
			$user->account->save();
			$this->get('session')->getFlashBag()->add(
				'noticesite',
				'Оплата поднятия в ТОП для объявления №'.$adv->getId().' прошла успешно!');
			$form = NULL;
		  } else {
			$this->get('session')->getFlashBag()->add(
				'alertsite',
				'Недостаточно денег для оплаты поднятия в ТОП. Пополните свой кошелек и повторите попытку.');
		  }
		}

		return $this->redirect($this->generateUrl('user_advs_page'));
        
    }
	
	######################################
  #     Оплата выделения цветом        #
	######################################
    public function advHighlightAction(Request $request) {
        
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        if ($error) {
            $error = $error->getMessage();
        }
        
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
        
        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;        
        
        # ------------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();        
		if (!is_object($user) || !$user instanceof UserInterface) {
            //throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
          $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId()); 
          
        }                 
                    
		$request_data = $request->request->all();
		$adv = AdvsQuery::create()->findOneById($request_data['forms']['id']);
		if ($request_data['forms']['paid_type'] == 1) {
		  if ($request_data['forms']['sum'] <= $user->account->getBalance()) {
			$transaction = new Transactions();
			$transaction->setEmail($user->getEmail());
			$transaction->setFosUserId($user->getId());
			$transaction->setSum($request_data['forms']['sum']);
			$transaction->setType('Оплата выделения цветом для объявления №'.$adv->getId());
			$transaction->setTransactionDate(date("Y-m-d H:i:s"));
			$transaction->save();
			$adv->setHlDate(strtotime("+14 days", strtotime(date("Y-m-d H:i:s"))));
			$adv->save();
			$user->account->setBalance($user->account->getBalance()-$request_data['forms']['sum']);
			$user->account->save();
			$this->get('session')->getFlashBag()->add(
				'noticesite',
				'Оплата выделения цветом для объявления №'.$adv->getId().' прошла успешно!');
			$form = NULL;
		  } else {
			$this->get('session')->getFlashBag()->add(
				'alertsite',
				'Недостаточно денег для оплаты выделения цветом. Пополните свой кошелек и повторите попытку.');
		  }
		}

		return $this->redirect($this->generateUrl('user_advs_page'));
        
    }
    
  ###############################################
  #     Размещение объявления в компании        #
	###############################################
    public function advCompanyAction(Request $request) {
        
    $session = $request->getSession();
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
        $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    } else {
        $error = '';
    }
    if ($error) {
        $error = $error->getMessage();
    }
    
    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
    
    $csrfToken = $this->container->has('form.csrf_provider')
        ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
        : null;        
    
    # ------------------------------------------------------------------------------------

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();        
		if (!is_object($user) || !$user instanceof UserInterface) {
            //throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }                       
                    
		$request_data = $request->request->all();
		$adv_id = $request_data['forms']['id'];
    $shop_id = $request_data['forms']['shop_id'];
    if ($adv_id && $shop_id) {      
      $adv = AdvsQuery::create()->findOneById($adv_id);
      $shop = ShopsQuery::create()->findOneById($shop_id);
      if ($adv && $shop) {
        $adv->setShopId($shop->getId());
        $adv->save();
        $this->get('session')->getFlashBag()->add(
				'noticesite',
				'Объявление №'.$adv->getId().' успешно размещено в компанию "'.$shop->getName().'"');
      }
    }
    
    return $this->redirect($this->generateUrl('user_advs_page'));
        
  }

  # Обработка текста
  public function text_transform($text)
  {

    # удаляем символы с конца
    $text = rtrim($text, ".,!!!?;:");
    
    # удаляем пробелы перед знаками препинания
    $text = preg_replace('/[\s]\./', '.', $text);    
    $text = preg_replace('/[\s]\,/', ',', $text);
    $text = preg_replace('/[\s]\!/', '!', $text);
    $text = preg_replace('/[\s]\?/', '?', $text);
    $text = preg_replace('/[\s]\;/', ';', $text);
    $text = preg_replace('/[\s]\:/', ':', $text);    
    
    # вставляем пробелы после точек и запятых (если следующий знак не цифра)
    $text = preg_replace("#(\S\.|\S,|\Ss,|\Ss,)(\D)#i", "$1 $2", $text);
    
    # удаляем двойные и более пробелы
    $text = preg_replace('/[\s]{2,}/', ' ', $text);    
    
    # первую букву Заглавной
    $text = $this->my_ucfirst($text);

    return $text;
  }
  
  function my_ucfirst($str, $encoding='UTF-8') {
    $str = mb_ereg_replace('^[\ ]+', '', $str);
    $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).mb_substr($str, 1, mb_strlen($str), $encoding);
    return $str;
  }
  
  ## Форматирование телефонного номера
  function format_phone($phone)
  {
    $phoneNumber = preg_replace('/[^0-9]/', '', $phone);

    if (strlen($phoneNumber) > 10)
    {
      $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
      $areaCode = substr($phoneNumber, -10, 3);
      $nextThree = substr($phoneNumber, -7, 3);
      $lastFour = substr($phoneNumber, -4, 4);

      $phoneNumber = (($countryCode == 8) ? '+7' : '+' . $countryCode) . '-' . $areaCode .
        '-' . $nextThree . '-' . $lastFour;
    }
    else
      if (strlen($phoneNumber) == 10)
      {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '+7-' . $areaCode . '-' . $nextThree . '-' . $lastFour;
      }
      else
        if (strlen($phoneNumber) == 7)
        {
          $nextThree = substr($phoneNumber, 0, 3);
          $lastFour = substr($phoneNumber, 3, 4);

          $phoneNumber = $nextThree . '-' . $lastFour;
        }
        else
        {
          $areaCode = substr($phoneNumber, 0, 3);
          $nextThree = substr($phoneNumber, 3, 3);
          $lastFour = substr($phoneNumber, 6);

          $phoneNumber = '' . $areaCode . '-' . $nextThree . '-' . $lastFour;
        }

        return $phoneNumber;
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
        $str = mb_strtolower($str, 'UTF-8');
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }
    
    function check_url($url) {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 200) {
            return $url;
        }
        curl_close($handle);
        return null;
    }

    function getNewFormText($text){
      $urlXml = $this->get_page("http://pyphrasy.herokuapp.com/inflect?phrase=".urlencode($text)."&cases=gent&cases=datv&cases=accs&cases=ablt&cases=loct");
      $result = @json_decode($urlXml);
      if($result){
          $arrData = array();
          foreach ($result as $one) {
             $arrData[] = (string)$one;
          }
          return $arrData;
      }
      return false;
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

<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\AdvPacketsQuery;
use Admin\AdminBundle\Model\JobPacketsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\FOSUserEvents;
use \Criteria;
use Admin\AdminBundle\Model\MenuQuery;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Admin\AdminBundle\Model\UserAccountQuery;
use Admin\AdminBundle\Model\TransactionsQuery;
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\AdvsQuery;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\PacketsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Symfony\Component\HttpFoundation\Session\Session;
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Model\UserFavoriteQuery;
use Admin\AdminBundle\Model\UserMessagesQuery;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class UserCabinetController extends Controller
{

    public function indexAction(Request $request) {

        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        # ------------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('admin.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $userManager = $this->container->get('fos_user.user_manager');

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_profile_show');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
        }

        return $this->render('SiteFirstPageBundle:Cabinet:index.html.twig',array(
            'last_username' => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'         => $error,
            'csrf_token'    => $csrfToken,
            'form'          => $form->createView(),
            'search_form'   => $search_form->createView(),
            'top_panel'     => $top_panel,
            'filt'          => $filt,
            'user'          => $user,            
            'menu'          => $menu
        ));
    }

    ############################################################################
    #                   Вывод списка объявлений пользователя                   #
    ############################################################################
    public function myadvsAction(Request $request)
    {

        $session = $request->getSession();

        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        #---------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
            $user->account = UserAccountQuery::create()
                ->findOneByFosUserId($user->getId());
        }

        # Выбираем действующие пакеты
        $packets = PacketsQuery::create()
            ->orderById()
            ->find();

        # Подключение пакетов услуг
        if ($request->request->all()) {
            $request_data = $request->request->all();
            $advs_array = array();
            if (@$request_data['adv']) foreach ($request_data['adv'] as $key => $value) {
                $advs_array[] = $key;
            }
            $packet_advs = AdvsQuery::create('Advs')
                ->filterById($advs_array)
                ->joinWith('AdvPackets',Criteria::LEFT_JOIN)
                ->find();
            foreach ($packet_advs as $packet_adv) {
                $packet = $packet_adv->getAdvPacketss();
                //var_dump($packet[0]);
                if (($packet[0]->getPacketId() > $request_data['packet']) || !$packet[0]->getPaid()) {
                  $packet[0]->setPacketId($request_data['packet']);
                  $packet[0]->setPaid(FALSE);
                  $packet[0]->setEnabled(TRUE);
                  $packet[0]->save();
                  if (count($request_data['adv'])>1) {
                    if ($packet[0]->getPacketId() == 3) {
                      $packet[0]->setPaid(TRUE);
                      $packet[0]->save();
                      $this->get('session')->getFlashBag()->add(
                        'noticesite',
                        'Для объявления № '.$packet[0]->getAdvId().' успешно подключен пакет "'.$packet[0]->getPackets()->getName().'".');
                    } else {
                      $this->get('session')->getFlashBag()->add(
                        'noticesite',
                        'Для объявления № '.$packet[0]->getAdvId().' успешно подключен пакет "'.$packet[0]->getPackets()->getName().'". Осталось оплатить пакет! <a class="btn btn-success" href="'.$this->generateUrl('paid_adv_page', array('id'=> $packet[0]->getId())).'" title="Оплатить пакет"><strong>Оплатить пакет!</strong></a>');                    
                    }
                  } else {
                    if ($packet[0]->getPacketId() == 3) {
                      $packet[0]->setPaid(TRUE);
                      $packet[0]->save();
                      $this->get('session')->getFlashBag()->add(
                        'noticesite',
                        'Для объявления № '.$packet[0]->getAdvId().' успешно подключен пакет "'.$packet[0]->getPackets()->getName().'".');
                    } else {
                      $this->get('session')->getFlashBag()->add(
                        'noticesite',
                        'Для объявления № '.$packet[0]->getAdvId().' успешно подключен пакет "'.$packet[0]->getPackets()->getName().'". Осталось оплатить пакет!');
                      if (@$request_data['ajax']) {
                        return new Response($this->generateUrl('paid_adv_page', array('id'=> $packet[0]->getId())));
                      } else {
                        return $this->redirect($this->generateUrl('paid_adv_page', array('id'=> $packet[0]->getId())));
                      }                      
                    }                        
                  }                  
                } else {
                  $this->get('session')->getFlashBag()->add(
                        'alertsite',
                        'Для объявления № '.$packet[0]->getAdvId().' уже подключен пакет "'.$packet[0]->getPackets()->getName().'".');
                }                               
            }
        }

        # -------- Объявления -----------

        # Выборка активных объявлений
        $advs_active = AdvsQuery::create('Advs')
            ->filterByUserId($user->getId())            
            ->filterByEnabled(true)
            ->filterByDeleted(false)
            ->join('Regions')
            ->join('AdCategories')
            ->join('AdvPackets',Criteria::LEFT_JOIN)
            ->orderBy('publish_date')
            ->find();

        foreach ($advs_active as $adv) {

            //var_dump($adv);
            # Втавляем путь категорий
            $adv->category = $adv->getAdCategories();
            $adv->parent_category = @$adv->category->parent ? $adv->category->parent : '';
            $adv->parent_parent_category = @$adv->parent_category->parent ? $adv->parent_category->parent : '';

            # Вставляем дату размещения объявления
            $adv->publish_d = @$adv->getPublishDate() ? $adv->getPublishDate()->format('d.m.y') : '';
            $adv->publish_b = @$adv->getPublishBeforeDate() ? $adv->getPublishBeforeDate()->format('d.m.y') : '';

            # Вставляем изображение или видео
            $adv->image = AdvImagesQuery::create()->orderById()->findOneByAdvId($adv->getId());
            $adv->video = AdvVideosQuery::create()->orderById()->findOneByAdvId($adv->getId());;
        }

        # Выборка неактивных объявлений
        $advs_inactive = AdvsQuery::create('Advs')
            ->filterByUserId($user->getId())
            ->where('Advs.Enabled = 0')
            ->_or()
            ->where('Advs.Deleted = 1')
            ->joinWith('Regions')
            ->joinWith('AdCategories')
            ->joinWith('AdvPackets',Criteria::LEFT_JOIN)
            ->orderBy('publish_date')
            ->find();


        foreach ($advs_inactive as $adv) {

            //var_dump($adv);
            # Втавляем путь категорий
            $adv->category = $adv->getAdCategories();
            $adv->parent_category = @$adv->category->parent ? $adv->category->parent : '';
            $adv->parent_parent_category = @$adv->parent_category->parent ? $adv->parent_category->parent : '';
            
            # Вставляем дату размещения объявления
            $adv->publish_d = @$adv->getPublishDate() ? $adv->getPublishDate()->format('d.m.y') : '';
            $adv->publish_b = @$adv->getPublishBeforeDate() ? $adv->getPublishBeforeDate()->format('d.m.y') : '';

            # Вставляем изображение или видео
            $adv->image = AdvImagesQuery::create()->orderById()->findOneByAdvId($adv->getId());
            $adv->video = AdvVideosQuery::create()->orderById()->findOneByAdvId($adv->getId());;
        }

        return $this->render('SiteFirstPageBundle:Cabinet:myadvs.html.twig',array(
            'last_username'     => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'top_panel'         => $top_panel,
            'packets'           => $packets,
            'filt'              => $filt,
            'search_form'       => $search_form->createView(),
            'advs_active'       => $advs_active,
            'advs_inactive'     => $advs_inactive,
            'user'              => $user,
            'menu'              => $menu
        ));
    }

	  ##################################
	  #   Обновление всех объявлений   #
	  ##################################

	  public function updateAllAdvsAction(Request $request)
	  {
		$user = $this->container->get('security.context')->getToken()->getUser();

		$advs = AdvsQuery::create('Advs')
			->filterByUserId($user->getId())
			->filterByEnabled(true)
			->filterByDeleted(false)
			->find();

		foreach ($advs as $adv) {
		  $adv->setPublishDate(date("Y-m-d H:i:s"));
		  $adv->setPublishBeforeDate(strtotime("+90 days", strtotime(date("Y-m-d H:i:s"))));
		  $adv->save();
		}

		return $this->render('SiteFirstPageBundle:Default:empty.html.twig');

	  }
    
    ############################################
	  #   Обновление всех объявлений из письма   #
	  ############################################

	  public function updateAllAdvsFromMailAction(Request $request)
	  {
		
      $email='';
      $email = @$request->query->get('user');
      if ($email) {
        $user = UserQuery::create()->findOneByEmail($email);
      
        if ($user) {          
          $advs = AdvsQuery::create('Advs')
            ->filterByUserId($user->getId())          
            ->filterByDeleted(false)
            ->find();

          foreach ($advs as $adv) {
            $adv->setPublishDate(date("Y-m-d H:i:s"));
            $adv->setPublishBeforeDate(strtotime("+90 days", strtotime(date("Y-m-d H:i:s"))));
            $adv->save();
          }          
                    
          return $this->render('SiteFirstPageBundle:Cabinet:update_email.html.twig', array('name' => $user->getRealname()));  
          
        }
      }
      
      return $this->redirect($this->generateUrl('user_cabinet_page'));      

	  }

    ############################################################################
    #                   Вывод списка избранных объявлений пользователя         #
    ############################################################################
    public function myfavoritesAction(Request $request)
    {

        $session = $request->getSession();

        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        #---------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
            $user->account = UserAccountQuery::create()
                ->findOneByFosUserId($user->getId());
        }

        # -------- Объявления -----------

        # Выборка избранных объявлений
        $f_advs = UserFavoriteQuery::create()
            ->filterByFosUserId($user->getId())            
            ->find();
        $f_ids = array();
        foreach ($f_advs as $f_adv) {
          $f_ids[] = $f_adv->getAdvId();
        }        
        
        $advs = AdvsQuery::create('Advs')
            ->filterById($f_ids)            
            ->find();

        return $this->render('SiteFirstPageBundle:Cabinet:myfavorites.html.twig',array(
            'last_username'     => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'top_panel'         => $top_panel,
            'filt'              => $filt,
            'search_form'       => $search_form->createView(),
            'advs'              => $advs,
            'user'              => $user,
            'menu'              => $menu
        ));
    }
	
	############################################################################
    #     Вывод списка избранных объявлений неавторизованного пользователя     #
    ############################################################################
    public function favoritesAction(Request $request)
    {

        $session = $request->getSession();

        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        #---------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();        
        if ($user !='anon.') {
            $user->account = UserAccountQuery::create()
                ->findOneByFosUserId($user->getId());
        }

        # -------- Объявления -----------

        # Выборка избранных объявлений
        
        $advs = AdvsQuery::create('Advs')
            ->filterById(@$_SESSION['favorite_advs'])            
            ->find();

        return $this->render('SiteFirstPageBundle:Cabinet:favorites.html.twig',array(
            'last_username'     => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'top_panel'         => $top_panel,
            'filt'              => $filt,
            'search_form'       => $search_form->createView(),
            'advs'              => $advs,
            'user'              => $user,
            'menu'              => $menu
        ));
    }
	
	############################################################################
    #                      Вывод списка компаний пользователя                  #
    ############################################################################
    public function mycompaniesAction(Request $request)
    {

        $session = $request->getSession();

        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        #---------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
            $user->account = UserAccountQuery::create()
                ->findOneByFosUserId($user->getId());
        }

        # -------- Объявления -----------

        # Выборка избранных объявлений
        $companies = ShopsQuery::create()
            ->filterByFosUserId($user->getId())            
            ->find();        

        return $this->render('SiteFirstPageBundle:Cabinet:mycompanies.html.twig',array(
            'last_username'     => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'top_panel'         => $top_panel,
            'filt'              => $filt,
            'search_form'       => $search_form->createView(),
            'companies'         => $companies,
            'user'              => $user,
            'menu'              => $menu
        ));
    }
	
	############################################################################
    #                      Вывод списка сообщений пользователю                 #
    ############################################################################
    public function mymessagesAction(Request $request)
    {

        $session = $request->getSession();

        #---- Единая конфигурация -------------------------------------------------------        

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());

        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        #---------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
            $user->account = UserAccountQuery::create()
                ->findOneByFosUserId($user->getId());            
        }

        # -------- Сообщения -----------

        # Выборка сообщений
        $messages = UserMessagesQuery::create()
            ->filterByFosUserId($user->getId())            
            ->orderByDate('DESC')
			->find();                

        return $this->render('SiteFirstPageBundle:Cabinet:mymessages.html.twig',array(
            'last_username'     => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'             => $error,
            'csrf_token'        => $csrfToken,            
            'top_panel'         => $top_panel,
            'filt'              => $filt,
            'search_form'       => $search_form->createView(),
            'messages'          => $messages,
            'user'              => $user,
            'menu'              => $menu
        ));
    }
	
	############################################################################
    #                      Показ полного сообщения пользователю                #
    ############################################################################
    public function fullMessageAction(Request $request)
    {
        
        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }        

        $request_data = $request->request->all();
        $id = $request_data['id'];
        # -------- Сообщение -----------

        # Выборка сообщения
        $message = UserMessagesQuery::create()
            ->filterByFosUserId($user->getId())            
            ->filterById($id)
            ->findOne();
        if ($message) {
          $message->setViewed(true);
          $message->save();
        }

        return $this->render('SiteFirstPageBundle:Cabinet:full_message.html.twig',array(            
            'message'          => $message
        ));
    }
    
	############################################################################
    #                           Баланс пользователя                            #
	############################################################################
    public function myBalanceAction(Request $request) {
        
        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());
        
        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        # ------------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
          $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());
          $user->transactions = TransactionsQuery::create()            
            ->filterByFosUserId($user->getId())
            ->orderByTransactionDate('desc')
            ->limit(10)
            ->find();       
        
            $user_advs = AdvsQuery::create()
              ->filterByUserId($user->getId())
              ->find();
            $advs = array();
            foreach ($user_advs as $user_adv) {
              $advs[] = $user_adv->getId();
            }        
              
            $paid_advs = AdvPacketsQuery::create()
              ->filterByAdvId($advs)
              ->filterByPaid(false)
              ->find();
          
        }
        
        $paid_advs = @$paid_advs ? $paid_advs : NULL;

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }        

        return $this->render('SiteFirstPageBundle:Cabinet:mybalance.html.twig',array(            
            'last_username' => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'         => $error,
            'csrf_token'    => $csrfToken,            
            'search_form'   => $search_form->createView(),
            'top_panel'     => $top_panel,
            'filt'          => '',
            'paid_advs'     => $paid_advs,
            'user'          => $user,            
            'menu'          => $menu
        ));
    }
    
	###########################
  #     Оплата пакета       #
	###########################
    public function paidAdvAction($id, Request $request) {
        
        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        # Формируем верхнюю панель
        $top_panel = $this->get('toppanel')->buildPanel($request);

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

        $search_form = $this->createForm(new SimpleSearchType());
        
        $menu = MenuQuery::create()->find();
        
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone=5, $request);
        
        # ------------------------------------------------------------------------------------

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }
        if ($user !='anon.') {
          $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId()); 
          
        }

        $paid_adv = AdvPacketsQuery::create()
              ->filterById($id)
              ->findOne();
            
        $form = $this->createFormBuilder($paid_adv)
            ->add('id', 'hidden', array('data' => $paid_adv->getId()))
            ->add('sum', 'hidden', array('data' => $paid_adv->getPackets()->getPrice(), 'mapped' => false))
            ->add('save', 'submit', array('attr' => array('class' => 'btn btn-primary pull-left', 'disabled' => ($paid_adv->getPackets()->getPrice() > $user->account->getBalance()?true:false)),'label' => 'Оплатить'))
            ->getForm();            

        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $request_data = $request->request->all();            
            if ($request_data['form']['sum'] <= $user->account->getBalance()) {
              $transaction = new Transactions();
              $transaction->setEmail($user->getEmail());
              $transaction->setFosUserId($user->getId());
              $transaction->setSum($request_data['form']['sum']);
              $transaction->setType('Оплата пакета "'.$paid_adv->getPackets()->getName().'" для объявления №'.$paid_adv->getId().' со счета кошелька');
              $transaction->setTransactionDate(date("Y-m-d H:i:s"));
              $transaction->save();
              $paid_adv->setPaid(TRUE);
              $paid_adv->setPaidDate(date("Y-m-d H:i:s"));
              $paid_adv->setUseBefore(strtotime( "+".$paid_adv->getPackets()->getDays()." days", strtotime( date("Y-m-d H:i:s") ) ));
              $paid_adv->getAdvs()->setUpDate(date("Y-m-d H:i:s"));
              // Автоматическая публикация в Telegram
              //$this->telegramPost($paid_adv->getAdvs());
              $paid_adv->save();
              $user->account->setBalance($user->account->getBalance()-$request_data['form']['sum']);
              $user->account->save();
              $this->get('session')->getFlashBag()->add(
                  'noticesite',
                  'Оплата пакета "'.$paid_adv->getPackets()->getName().'" для объявления №'.$paid_adv->getAdvId().' прошла успешно!');
              $form = NULL;
            } else {
              $this->get('session')->getFlashBag()->add(
                  'alertsite',
                  'Недостаточно денег для оплаты выбранного пакета. Пополните свой кошелек и повторите попытку.');
            }
            return $this->redirect($this->generateUrl('user_advs_page'));
            
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }        

        return $this->render('SiteFirstPageBundle:Cabinet:paid_adv.html.twig',array(            
            'last_username' => $lastUsername,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'error'         => $error,
            'csrf_token'    => $csrfToken,            
            'search_form'   => $search_form->createView(),
            'top_panel'     => $top_panel,
            'filt'          => '',
            'form'          => @$form ? $form->createView() : NULL,
            'paid_adv'      => $paid_adv,
            'user'          => $user,            
            'menu'          => $menu
        ));
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
    
  ########################################
  #     Возврат к пакету Бесплатно       #
	########################################
    public function freeAdvAction($id, Request $request) {

        # ---- Данные пользователя ----
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('У вас нет доступа к данной странице.');
        }        

        $free_adv = AdvPacketsQuery::create()
              ->filterById($id)
              ->findOne();
              
        if ($free_adv) {
          $free_adv->setPacketId(3);
          $free_adv->setPaid(TRUE);
          $free_adv->setPaidDate(date("Y-m-d H:i:s"));
          $free_adv->save();
          $this->get('session')->getFlashBag()->add(
                  'noticesite',
                  'Для объявления №'.$free_adv->getAdvId().' установлен пакет "'.$free_adv->getPackets()->getName().'"!');
        }        
            
        return $this->redirect($this->generateUrl('user_advs_page'));
    }
}

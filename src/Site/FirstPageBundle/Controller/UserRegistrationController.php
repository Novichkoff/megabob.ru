<?php

namespace Site\FirstPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\MenuQuery;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Controller\RegistrationController;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Site\FirstPageBundle\Form\ExtFilter;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\UserAccount;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Symfony\Component\HttpFoundation\Session\Session;
use Admin\AdminBundle\Model\Transactions;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserRegistrationController extends Controller
{

    public function indexAction(Request $request)
    {
        #---- Единая конфигурация -------------------------------------------------------

        # GET-запросы
        $this->get('get_params')->build($request);

        #---- Баннеры --------
        $banner_top = $this->get('banner')->select($zone=1, $request);
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_advs = $this->get('banner')->select($zone=3, $request);
        #------------------------------

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
        
        # ------------------------------------------------------------------------------------

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        $form = $formFactory->createForm();        
        $form->remove('username');
        $form->add('username','hidden');
        $form->add('realname', 'text', array('label'  => 'Ваше имя', 'required' => TRUE, 'attr'=>array('class'=>'form-control')));
        $form->add('phone', 'text', array('label'  => 'Номер телефона', 'required' => TRUE, 'attr'=>array('class'=>'form-control')));
        $form->add('captcha', 'captcha', array('label'  => 'Проверочный код', 'required' => TRUE, 'attr'=>array('class'=>'form-control')));         
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            ## Добавление нового пользователя
            if ($form->isValid()) {                
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $user->setUsername($user->getEmail());
                $user->setCreateDate(date("Y-m-d H:i:s"));
                $user->setEmailToken(md5(uniqid()));
                $user->setPhoneCode(rand(111111, 999999));
                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                $user_account = new UserAccount();
                $user_account->setFosUserId($user->getId());
                $user_account->setBalance(0);
                $user_account->save();                
                
                # Отправляем пользователю письмо о регистрации 
                $subject = 'Добро пожаловать на '.$top_panel['settings']->getName();
                $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
                $to = $user->getEmail();
                $body = $this->renderView(
                    'SiteFirstPageBundle:Adv:email.txt.twig',
                    array('top_panel' => $top_panel, 'username' => $user->getUsername(), 'realname' => $user->getRealname(), 'user' => $user, 'email' => $user->getEmail(), 'email_token' => $user->getEmailToken(),'password' => $request->request->all()["fos_user_registration_form"]["plainPassword"]["first"])
                );
                if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) $this->get('session')->getFlashBag()->add(
                    'noticesite',
                    'Письмо с регистрационными данными успешно отправлено');

                return $response;
            }
        }

        return $this->render('SiteFirstPageBundle:Registration:index.html.twig',array(
            'last_username'     => $lastUsername,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'banner_top'        => $banner_top,
            'banner_search'     => $banner_search,
            'banner_advs'       => $banner_advs,
            'search_form'       => $search_form->createView(),
            'filt'              => $filt,
            'form'              => $form->createView(),
            'top_panel'         => $top_panel,            
            'menu'              => $menu
        ));
    }
	
	# Отправка ссылки для активации Email
	public function emailActivationSendAction($id, Request $request)
    {
		
		$top_panel = $this->get('toppanel')->buildPanel($request);
    $tuser = UserQuery::create()->filterById($id)->findOne();		
		if (@$tuser->getId()) {			
			# Отправляем пользователю письмо со ссылкой
			$subject = 'Подтверждение Email на '.$top_panel['settings']->getName();
			$from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
			$to = $tuser->getEmail();
			$body = $this->renderView(
				'SiteFirstPageBundle:Adv:email_confirm.txt.twig',
				array('top_panel' => $top_panel, 'username' => $tuser->getUsername(), 'realname' => $tuser->getRealname(), 'email' => $tuser->getEmail(), 'email_token' => $tuser->getEmailToken())
			);
			if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) $this->get('session')->getFlashBag()->add(
				'noticesite',
				'Письмо со ссылкой для подтверждения Email успешно отправлено на '.$tuser->getEmail());
		} else {
			$this->get('session')->getFlashBag()->add(
				'noticesite',
				'Не удалось отправить ссылку на '.$tuser->getEmail().'. Пожалуйста, обратитесь к администрации сайта.');
		}
		return $this->redirect($this->generateUrl('user_cabinet_page'));
	}
	
	# Активация Email
	public function emailActivationAction(Request $request)
    {
		$name = NULL;
		$token = $request->query->get('token');
		$tuser = UserQuery::create()->filterByEmailToken($token)->findOne();		
		if (@$tuser->getId()) {			
			$tuser->setEmailConfirm(TRUE);			
			$tuser->save();			
			$name = $tuser->getRealname();
      // Автовход
      $ftoken = new UsernamePasswordToken($tuser, null, 'main', $tuser->getRoles());
      $this->get('security.context')->setToken($ftoken);
      $this->get('session')->set('_security_main',serialize($ftoken));
		}
		return $this->render('SiteFirstPageBundle:Registration:confirm_email.html.twig', array('name' => $name));
	}
	
	# Отписаться от всех писем
	public function unsubscriberAction(Request $request)
    {		
		$s_email = NULL;
		$email = $request->query->get('email');
		$email_user = UserQuery::create()->filterByEmail($email)->findOne();
		if (@$email_user->getId()) {			
			$email_user->setEmailStatus(FALSE);
			$s_email = $email_user->getEmail();
			$email_user->save();
		}
		return $this->render('SiteFirstPageBundle:Registration:unsubscribe.html.twig', array('email' => $s_email));
	}
	
	# Отписаться от писем о новых объявлениях
	public function unsubscribeAction(Request $request)
    {		
		$email = NULL;
		$token = $request->query->get('token');
		$subscriber = AdCategoriesSubscribeQuery::create()
			->filterByUnsubscribeCode($token)
			->findOne();
		if (@$subscriber->getId()) {			
			$email = $subscriber->getEmail();			
			$subscriber->delete();
		}
		return $this->render('SiteFirstPageBundle:Registration:unsubscribe.html.twig', array('email' => $email));
	}
    
}

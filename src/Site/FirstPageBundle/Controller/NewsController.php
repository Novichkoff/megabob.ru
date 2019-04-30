<?php

namespace Site\FirstPageBundle\Controller;
use Admin\AdminBundle\Model\UserAccountQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\RegionsQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Site\FirstPageBundle\Controller\TopPanel;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Admin\AdminBundle\Model\NewsQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class NewsController extends Controller
{

    ##################################################
    #                     Новости                    #
    ##################################################

    public function newsAction(Request $request) {

        #---- Единая конфигурация -------------------------------------------------------
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone = 5, $request);
        #------------------------------

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

        # Данные пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user !='anon.') $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());

        #---------------------------------------------------------------------------------

        $pages = NewsQuery::create()            
            ->orderByCreatedAt('DESC')
			->find();
			
		$paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $pages,
            $this->get('request')->query->get('page', 1),
            20
        );
			
		$response = new Response();
    if (count($pages)) $response->setLastModified($pages[0]->getCreatedAt());
		$response->setPublic();
		//$response->setMaxAge(3600);
		//$date = new \DateTime();
		//$date->modify('+1 day');
		//$response->setExpires($date);
		
		return $this->render('SiteFirstPageBundle:News:news.html.twig',array(
            'last_username'     => $lastUsername,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'top_panel'         => $top_panel,
            'search_form'       => $search_form->createView(),
            'user'              => $user,
            'filt'              => $filt,
            'pagination'        => $pagination,
            'menu'              => $menu
        ),$response);
    }
	
    ##################################################
    #                     Новость                    #
    ##################################################

    public function indexAction($alias, Request $request) {

        #---- Единая конфигурация -------------------------------------------------------
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request);
        $banner_right = $this->get('banner')->select($zone=4, $request);
        $banner_bottom = $this->get('banner')->select($zone = 5, $request);
        #------------------------------

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

        # Данные пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user !='anon.') $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());

        #---------------------------------------------------------------------------------

        $page = NewsQuery::create()
            ->filterByAlias($alias)
            ->findOne();
			
		$page->setViewed($page->getViewed()+1);
		$page->save();
		
		$response = new Response();	
		$response->setLastModified($page->getCreatedAt());
		$response->setPublic();
		//$response->setMaxAge(3600);
		//$date = new \DateTime();
		//$date->modify('+1 day');
		//$response->setExpires($date);
			
		return $this->render('SiteFirstPageBundle:News:index.html.twig',array(
            'last_username'     => $lastUsername,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'top_panel'         => $top_panel,
            'search_form'       => $search_form->createView(),
            'user'              => $user,
            'filt'              => $filt,
            'page'              => $page,            
            'menu'              => $menu
        ),$response);
    }
}
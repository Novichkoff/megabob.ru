<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\UserAccountQuery;
use Admin\AdminBundle\Model\UserFavoriteQuery;
use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Site\FirstPageBundle\Form\Comment;
use Site\FirstPageBundle\Form\Subscribe;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvComments;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvComplaine;
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Symfony\Component\HttpFoundation\Response;

class OneAdvController extends Controller
{
  
  ##################################################################################
  #                             Вывод одного объявления                            #
  ##################################################################################

  public function advAction($region,$category,$subcategory,$id,$alias, Request $request)
  {

    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_bottom = $this->get('banner')->select($zone = 5, $request);
    $banner_right = $this->get('banner')->select($zone = 4, $request);
    
    #------------------------------
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

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'hide';

    $menu = MenuQuery::create()->find();

    #---------------------------------------------------------------------------------
    # Данные пользователя
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    # Комментарии
    $comment = new AdvComments();
    $comment_form = $this->createForm(new Comment(), $comment);
    $comment_form->handleRequest($request);

    if ($comment_form->isValid())
    {
      $comment->setAdvId($id);
      $comment->setFosUserId($user->getId());
      $comment->save();

      $comment = new AdvComments();
      $comment_form = $this->createForm(new Comment(), $comment);
    }

    # Выборка объявления
    $adv_query = AdvsQuery::create();
    $adv_query->join('Regions');
    $adv_query->join('User');
    $adv_query->join('AdCategories');

    # Комментарии
    $adv_query->join('AdvComments', Criteria::LEFT_JOIN);
    $adv_query->join('AdvPrice', Criteria::LEFT_JOIN);
	
    $adv_query->join('AdvImages', Criteria::LEFT_JOIN);
    $adv_query->join('AdvParams Params', Criteria::LEFT_JOIN);
    $adv_query->join('Params.AdCategoriesFields', Criteria::LEFT_JOIN);
    $adv_query->join('Params.AdCategoriesFieldsValues', Criteria::LEFT_JOIN);
    //$adv_query->orderBy('AdvImages.Id','DESC');
    $adv_query->filterById($id);
    $adv = $adv_query->findOne();
    if (!$adv)
    {
      $search_form = $this->createForm(new SimpleSearchType());
      $response = new Response();

      $response = $this->render('SiteFirstPageBundle:Default:no_adv.html.twig', array
        (
        'last_username' => $lastUsername,
        'error' => $error,
        'csrf_token' => $csrfToken,        
        'banner_search' => $banner_search,
        'banner_right' => $banner_right,
        'banner_bottom' => $banner_bottom,
        'top_panel' => $top_panel,
        'search_form' => $search_form->createView(),
        'filt' => $filt,
        'user' => $user,
        'menu' => $menu));
      $response->setStatusCode(410, 'Gone');
      return $response;
    }    

    # Увеличиваем счетчик просмотров объявления
    $useragent = $_SERVER['HTTP_USER_AGENT'];

		# Отсеиваем ботов
		if (!preg_match("/bot/i", $useragent)) {		  
      # Есть ли уже просмотренные объявления в текущей сессии
      if (@$_SESSION['viewed_advs']) {        
        # Отсеиваем уже смотревших объявление
        if (!in_array($adv->getId(), $_SESSION['viewed_advs'])) {
          array_push($_SESSION['viewed_advs'], $adv->getId());
          # Отсеиваем авторов объявления и админов с модераторами
          if ($user != 'anon.') {
            if ($user->getId() != $adv->getUserId() && !$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN') && !$this->get('security.context')->isGranted('ROLE_MODER')) {
              $adv->setCnt($adv->getCnt() + 1);
              $adv->setCntToday($adv->getCntToday() + 1);
              $adv->setLastViewDate(date("Y-m-d H:i:s"));
              $adv->save();
            } 
          } else {
            $adv->setCnt($adv->getCnt() + 1);
            $adv->setCntToday($adv->getCntToday() + 1);
            $adv->setLastViewDate(date("Y-m-d H:i:s"));
            $adv->save();
          }          
        }
		  } else {
        $_SESSION['viewed_advs'] = array();
        array_push($_SESSION['viewed_advs'], $adv->getId());
        # Отсеиваем авторов объявления и админов с модераторами
        if ($user != 'anon.') {
          if ($user->getId() != $adv->getUserId() && !$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN') && !$this->get('security.context')->isGranted('ROLE_MODER')) {
            $adv->setCnt($adv->getCnt() + 1);
            $adv->setCntToday($adv->getCntToday() + 1);
            $adv->setLastViewDate(date("Y-m-d H:i:s"));
            $adv->save();
          } 
        } else {
          $adv->setCnt($adv->getCnt() + 1);
          $adv->setCntToday($adv->getCntToday() + 1);
          $adv->setLastViewDate(date("Y-m-d H:i:s"));
          $adv->save();
        }  
		  }      
		}
    
    # Регион и город
    $_SESSION['region_id'] = $adv->getRegionId();
    $_SESSION['area_id'] = $adv->getAreaId();

    # Категория объявления, дочерние, родительская и соседние категории    
    $category = $adv->getAdCategories();
    $category->childs = $category->getAdChildss();

    $category->parent = $category->getAdCategoriesRelatedByParentId();
    $parent_category = $category->getAdCategoriesRelatedByParentId();
    if ($parent_category)
    {
      $parent_category->childs = $parent_category->getAdChildss();
    }
    else  $parent_category = $category;    

    $search_form = $this->createForm(new SimpleSearchType(), $category);

    # -------- Объявление -----------
    # Поля категории
    $fields = array();

    $category_fields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($category->
        getParentId(), $category->getId()))->orderByType()->orderByName()->findByArray(array('deleted' => false,
        'enabled' => true));

    foreach ($category_fields as $category_field)
    {
      $fields[$category_field->getId()] = $category_field;
    }

    $category_array = array();
    $category_array[] = $category->getId();
    if ($category->childs)
      foreach ($category->childs as $category_child)
      {
        $category_array[] = $category_child->getId();
      }


    if ($adv)
    {

      # Втавляем путь категорий
      $adv->category = $adv->getAdCategories();
      $adv->parent_category = @$adv->category->parent ? $adv->category->parent : '';
      $adv->parent_parent_category = @$adv->parent_category->parent ? $adv->
        parent_category->parent : '';

      # Форматируем номер телефона
      $adv->setPhone($this->format_phone($adv->getPhone()));

      # Заполняем Дополнительные поля
      $adv->params = array();

      foreach ($adv->getAdvParamss()->getData() as $param)
      {
        if ($param->getValueId())
        {
          if (@$param->getAdCategoriesFieldsValues())
          {
            $adv->params[$param->getFieldId()] = $param->getAdCategoriesFieldsValues()->
              getName();
          }
        }
        elseif (@$param->getTextValue())
        {
          $adv->params[$param->getFieldId()] = $param->getTextValue();
        }
        else
        {
          $adv->params[$param->getFieldId()] = '';
        }
      }	

      # Статистика объявления
      $adv->stats = AdvsStatQuery::create()->filterByAdvId($adv->getId())->
        orderByStatDate('DESC')->limit(10)->find();
    }

    # Комментарии
    $comments = $adv->getAdvCommentss();

    # Вы смотрели
    $yadvs = array();
    if (@$_SESSION['viewed_advs']) $yadvs = AdvsQuery::create()->filterById($_SESSION['viewed_advs'])->find();      
    
    $similar_advs_array = array($id);    
    
    # Похожие объявления в городе
    $similar_advs_query = AdvsQuery::create('Advs');
    $similar_advs_query->filterByCategoryId($category_array);
    $similar_advs_query->join('AdvImages', Criteria::LEFT_JOIN);
    $similar_advs_query->withColumn('AdvImages.Id', 'photo');
    $similar_advs_query->withColumn('AdvImages.Thumb', 'thumb');
    $similar_advs_query->groupBy('Id');
    $similar_advs_query->where('Advs.Id NOT IN ?', $similar_advs_array);
    $similar_advs_query->join('Regions', Criteria::LEFT_JOIN);
    $similar_advs_query->where('Regions.Id = ?', $adv->getRegionId());
    $similar_advs_query->orderBy('publishDate', 'desc');
    $similar_advs_query->limit(5);
    $similar_advs = $similar_advs_query->filterByArray(array('enabled' => true,'deleted' => false))->find();    
    foreach ($similar_advs as $similar_adv) {
      $similar_advs_array[]=$similar_adv->getId();
    }	
    
    # Похожие объявления в регионе
    $r_similar_advs = array();
    if (count($similar_advs) < 5) {
      $r_similar_advs_query = AdvsQuery::create('Advs');
      $r_similar_advs_query->where('Advs.Id NOT IN ?', $similar_advs_array);
      $r_similar_advs_query->join('AdvImages', Criteria::LEFT_JOIN);
      $r_similar_advs_query->withColumn('AdvImages.Id', 'photo');
      $r_similar_advs_query->withColumn('AdvImages.Thumb', 'thumb');
      $r_similar_advs_query->groupBy('Id');
      $r_similar_advs_query->filterByCategoryId($category_array);
      $r_similar_advs_query->join('Areas', Criteria::LEFT_JOIN);    
      $r_similar_advs_query->where('Areas.Id = ?', $adv->getAreaId());
      $r_similar_advs_query->orderBy('publishDate', 'desc');
      $r_similar_advs_query->limit(5);
      $r_similar_advs = $r_similar_advs_query->filterByArray(array('enabled' => true,'deleted' => false))->find();
    }
    

    # Параметры ответа сервера
    $response = new Response();
    $response->headers->addCacheControlDirective('must-revalidate', true);	  
    $response->headers->addCacheControlDirective('no-store', true);
    $response->headers->addCacheControlDirective('no-cache', true);
    if ($user == 'anon.') {
      $response->setLastModified($adv->getPublishDate());
      $response->setPrivate();
      $response->setETag(md5($adv->getDescription()));	  
    }
    
    return $this->render('SiteFirstPageBundle:Default:adv.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_search' => $banner_search,
      'banner_right' => $banner_right,
      'banner_bottom' => $banner_bottom,      
      'top_panel' => $top_panel,
      'search_form' => $search_form->createView(),
      'category' => $category,
      'parent_category' => $parent_category,
      'fields' => $fields,
      'filt' => $filt,
      'adv' => $adv,
      'yadvs' => $yadvs,
      'comments' => $comments,
      'comment_form' => $comment_form->createView(),
      'similar_advs' => $similar_advs,
      'r_similar_advs' => $r_similar_advs,      
      'user' => $user,
      'menu' => $menu), $response);
  }
  
  ##################################################################################
  #                             Вывод одного объявления                            #
  ##################################################################################

  public function randomAdvAction(Request $request)
  {

    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 6, $request);
    $banner_advs_s = $this->get('banner')->select($zone = 6, $request);
    $banner_bottom = $this->get('banner')->select($zone = 5, $request);
    $banner_right = $this->get('banner')->select($zone = 4, $request);
    
    #------------------------------
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

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'hide';

    $menu = MenuQuery::create()->find();

    #---------------------------------------------------------------------------------
    # Данные пользователя
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    # Комментарии
    $comment = new AdvComments();
    $comment_form = $this->createForm(new Comment(), $comment);
    $comment_form->handleRequest($request);

    if ($comment_form->isValid())
    {
      $comment->setAdvId($id);
      $comment->setFosUserId($user->getId());
      $comment->save();

      $comment = new AdvComments();
      $comment_form = $this->createForm(new Comment(), $comment);
    }

    # Выборка объявления
    $adv_query = AdvsQuery::create();
    $adv_query->join('Regions');
    $adv_query->join('User');
    $adv_query->join('AdCategories');

    # Комментарии
    $adv_query->join('AdvComments', Criteria::LEFT_JOIN);
    $adv_query->join('AdvPrice', Criteria::LEFT_JOIN);
	
    $adv_query->join('AdvImages', Criteria::LEFT_JOIN);
    $adv_query->join('AdvParams Params', Criteria::LEFT_JOIN);
    $adv_query->join('Params.AdCategoriesFields', Criteria::LEFT_JOIN);
    $adv_query->join('Params.AdCategoriesFieldsValues', Criteria::LEFT_JOIN);
    //$adv_query->orderBy('AdvImages.Id','DESC'); 
    $adv_query->join('AdvPackets', Criteria::LEFT_JOIN);
    $adv_query->where('AdvPackets.PacketId in (1,2)');
    $adv_query->where('AdvPackets.Paid = ?', 1);
    $adv_query->where('AdvPackets.UseBefore >= ?', strtotime(date("Y-m-d H:i:s")));    
    $adv_query->filterByArray(array('enabled' => true, 'deleted' => false));
    $adv_query->orderBy('LastViewDate','ASC');
    $adv = $adv_query->findOne();
    
    if (!$adv)
    {
      $search_form = $this->createForm(new SimpleSearchType());
      $response = new Response();

      $response = $this->render('SiteFirstPageBundle:Default:no_adv.html.twig', array
        (
        'last_username' => $lastUsername,
        'error' => $error,
        'csrf_token' => $csrfToken,        
        'banner_search' => $banner_search,
        'banner_advs' => $banner_advs,
        'banner_right' => $banner_right,
        'banner_bottom' => $banner_bottom,
        'top_panel' => $top_panel,
        'search_form' => $search_form->createView(),
        'filt' => $filt,
        'user' => $user,
        'menu' => $menu));
      $response->setStatusCode(410, 'Gone');
      return $response;
    }    

    # Увеличиваем счетчик просмотров объявления
    $useragent = $_SERVER['HTTP_USER_AGENT'];

		# Отсеиваем ботов
		if (!preg_match("/bot/i", $useragent)) {		  
      # Есть ли уже просмотренные объявления в текущей сессии
      if (@$_SESSION['viewed_advs']) {        
        # Отсеиваем уже смотревших объявление
        if (!in_array($adv->getId(), $_SESSION['viewed_advs'])) {
          array_push($_SESSION['viewed_advs'], $adv->getId());
          # Отсеиваем авторов объявления и админов с модераторами
          if ($user != 'anon.') {
            if ($user->getId() != $adv->getUserId() && !$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN') && !$this->get('security.context')->isGranted('ROLE_MODER')) {
              $adv->setCnt($adv->getCnt() + 1);
              $adv->setCntToday($adv->getCntToday() + 1);
              $adv->setLastViewDate(date("Y-m-d H:i:s"));
              $adv->save();
            } 
          } else {
            $adv->setCnt($adv->getCnt() + 1);
            $adv->setCntToday($adv->getCntToday() + 1);
            $adv->setLastViewDate(date("Y-m-d H:i:s"));
            $adv->save();
          }          
        }
		  } else {
        $_SESSION['viewed_advs'] = array();
        array_push($_SESSION['viewed_advs'], $adv->getId());
        # Отсеиваем авторов объявления и админов с модераторами
        if ($user != 'anon.') {
          if ($user->getId() != $adv->getUserId() && !$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN') && !$this->get('security.context')->isGranted('ROLE_MODER')) {
            $adv->setCnt($adv->getCnt() + 1);
            $adv->setCntToday($adv->getCntToday() + 1);
            $adv->setLastViewDate(date("Y-m-d H:i:s"));
            $adv->save();
          } 
        } else {
          $adv->setCnt($adv->getCnt() + 1);
          $adv->setCntToday($adv->getCntToday() + 1);
          $adv->setLastViewDate(date("Y-m-d H:i:s"));
          $adv->save();
        }  
		  }      
		}
    
    # Регион и город
    $_SESSION['region_id'] = $adv->getRegionId();
    $_SESSION['area_id'] = $adv->getAreaId();

    # Категория объявления, дочерние, родительская и соседние категории    
    $category = $adv->getAdCategories();
    $category->childs = $category->getAdChildss();

    $category->parent = $category->getAdCategoriesRelatedByParentId();
    $parent_category = $category->getAdCategoriesRelatedByParentId();
    if ($parent_category)
    {
      $parent_category->childs = $parent_category->getAdChildss();
    }
    else  $parent_category = $category;    

    $search_form = $this->createForm(new SimpleSearchType(), $category);

    # -------- Объявление -----------
    # Поля категории
    $fields = array();

    $category_fields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($category->
        getParentId(), $category->getId()))->orderByType()->orderByName()->findByArray(array('deleted' => false,
        'enabled' => true));

    foreach ($category_fields as $category_field)
    {
      $fields[$category_field->getId()] = $category_field;
    }

    $category_array = array();
    $category_array[] = $category->getId();
    if ($category->childs)
      foreach ($category->childs as $category_child)
      {
        $category_array[] = $category_child->getId();
      }


    if ($adv)
    {

      # Втавляем путь категорий
      $adv->category = $adv->getAdCategories();
      $adv->parent_category = @$adv->category->parent ? $adv->category->parent : '';
      $adv->parent_parent_category = @$adv->parent_category->parent ? $adv->
        parent_category->parent : '';

      # Форматируем номер телефона
      $adv->setPhone($this->format_phone($adv->getPhone()));

      # Заполняем Дополнительные поля
      $adv->params = array();

      foreach ($adv->getAdvParamss()->getData() as $param)
      {
        if ($param->getValueId())
        {
          if (@$param->getAdCategoriesFieldsValues())
          {
            $adv->params[$param->getFieldId()] = $param->getAdCategoriesFieldsValues()->
              getName();
          }
        }
        elseif (@$param->getTextValue())
        {
          $adv->params[$param->getFieldId()] = $param->getTextValue();
        }
        else
        {
          $adv->params[$param->getFieldId()] = '';
        }
      }	

      # Статистика объявления
      $adv->stats = AdvsStatQuery::create()->filterByAdvId($adv->getId())->
        orderByStatDate('DESC')->limit(10)->find();
    }

    # Комментарии
    $comments = $adv->getAdvCommentss();

    # Вы смотрели
    $yadvs = array();
    if (@$_SESSION['viewed_advs']) $yadvs = AdvsQuery::create()->filterById($_SESSION['viewed_advs'])->find();      
    
    $similar_advs_array = array($adv->getId());    
    
    # Похожие объявления в городе
    $similar_advs_query = AdvsQuery::create('Advs');
    $similar_advs_query->filterByCategoryId($category_array);
    $similar_advs_query->join('AdvImages', Criteria::LEFT_JOIN);
    $similar_advs_query->withColumn('AdvImages.Id', 'photo');
    $similar_advs_query->withColumn('AdvImages.Thumb', 'thumb');
    $similar_advs_query->groupBy('Id');
    $similar_advs_query->where('Advs.Id NOT IN ?', $similar_advs_array);
    $similar_advs_query->join('Regions', Criteria::LEFT_JOIN);
    $similar_advs_query->where('Regions.Id = ?', $adv->getRegionId());
    $similar_advs_query->orderBy('publishDate', 'desc');
    $similar_advs_query->limit(5);
    $similar_advs = $similar_advs_query->filterByArray(array('enabled' => true,'deleted' => false))->find();    
    foreach ($similar_advs as $similar_adv) {
      $similar_advs_array[]=$similar_adv->getId();
    }	
    
    # Похожие объявления в регионе
    $r_similar_advs = array();
    if (count($similar_advs) < 5) {
      $r_similar_advs_query = AdvsQuery::create('Advs');
      $r_similar_advs_query->where('Advs.Id NOT IN ?', $similar_advs_array);
      $r_similar_advs_query->join('AdvImages', Criteria::LEFT_JOIN);
      $r_similar_advs_query->withColumn('AdvImages.Id', 'photo');
      $r_similar_advs_query->withColumn('AdvImages.Thumb', 'thumb');
      $r_similar_advs_query->groupBy('Id');
      $r_similar_advs_query->filterByCategoryId($category_array);
      $r_similar_advs_query->join('Areas', Criteria::LEFT_JOIN);    
      $r_similar_advs_query->where('Areas.Id = ?', $adv->getAreaId());
      $r_similar_advs_query->orderBy('publishDate', 'desc');
      $r_similar_advs_query->limit(5);
      $r_similar_advs = $r_similar_advs_query->filterByArray(array('enabled' => true,'deleted' => false))->find();
    }
    

    # Параметры ответа сервера
    $response = new Response();
    $response->headers->addCacheControlDirective('must-revalidate', true);	  
    $response->headers->addCacheControlDirective('no-store', true);
    $response->headers->addCacheControlDirective('no-cache', true);
    if ($user == 'anon.') {
      $response->setLastModified($adv->getPublishDate());
      $response->setPrivate();
      $response->setETag(md5($adv->getDescription()));	  
    }
    
    return $this->render('SiteFirstPageBundle:Default:adv.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => null,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_advs_s' => $banner_advs_s,
      'banner_right' => $banner_right,
      'banner_bottom' => $banner_bottom,
      'banner_adv' => null,
      'top_panel' => $top_panel,
      'search_form' => $search_form->createView(),
      'category' => $category,
      'parent_category' => $parent_category,
      'fields' => $fields,
      'filt' => $filt,
      'adv' => $adv,
      'yadvs' => $yadvs,
      'comments' => $comments,
      'comment_form' => $comment_form->createView(),
      'similar_advs' => $similar_advs,
      'r_similar_advs' => $r_similar_advs,      
      'user' => $user,
      'menu' => $menu), $response);
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

}
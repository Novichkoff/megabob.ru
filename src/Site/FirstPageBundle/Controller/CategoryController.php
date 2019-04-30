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
use Site\FirstPageBundle\Controller\Adv;
use Site\FirstPageBundle\Controller\NewsItem;
use Site\FirstPageBundle\Controller\AdvVk;
use Site\FirstPageBundle\Controller\Auto;
use Site\FirstPageBundle\Controller\Realty;
use Site\FirstPageBundle\Controller\Vacancy;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvComments;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\NewsQuery;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\AdvComplaine;
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\UserFavorite;
use Admin\AdminBundle\Model\UserMessages;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Field\Item\MediaItemField;
use Symfony\Component\HttpFoundation\Response;
use Eko\FeedBundle\Field\Item\ItemField;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class CategoryController extends Controller
{	
  ############################################################################
  #                 Вывод списка объявлений внутри категории                 #
  ############################################################################

  public function categoryAction($category, $subcategory, $parametr_1, $parametr_2, $parametr_3, Request $request)
  {

    if ($category == $subcategory) return $this->redirect($this->generateUrl('site_category_page',array(
        'category'=>$category,
        'subcategory'=>null,
        'region'=>$request->attributes->get('region'))));
        
    $session = $request->getSession();
    $_SESSION['category_alias'] = $subcategory;

    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    # Формируем верхнюю панель
    $top_panel = $this->get('toppanel')->buildPanel($request);
    
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
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
    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;    

    $menu = MenuQuery::create()->find();

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
    #---------------------------------------------------------------------------------
    # Категория, дочерние, родительская и соседние категории
    # Выбор Категории объявления

    $category = AdCategoriesQuery::create()
                    ->filterByAlias($subcategory?$subcategory:$category)
                    ->orderByName()
                    ->findOne();

    if (!$category) {
      throw $this->createNotFoundException('Категория не существует');
    }
	
    # ---- Баннеры ----
    $banner_search    = $this->get('banner')->select($zone = 2, $request, $category);
    $banner_right     = $this->get('banner')->select($zone = 4, $request, $category);
    $banner_bottom    = $this->get('banner')->select($zone = 5, $request, $category);    

    $search_form = $this->createForm(new SimpleSearchType(), $category);

    /*
    $category->childs = ($category->getParentId() != 0) ? $category->getAdChildss() : '';
    $category->parent = @$category->getAdCategoriesRelatedByParentId() ? $category->getAdCategoriesRelatedByParentId() : $category;
    */

    // SEO    
    $h1 = $category->getName();
    $page_title = $this->seo($category->getPagetitle(),$top_panel);
    $page_description = $this->seo($category->getCatchPhrase(),$top_panel);
    $page_text = $this->seo($category->getText(),$top_panel);
    
    /*
    $category->advcnt = 0;
    if ($category->childs) {
      foreach ($category->childs as $category_item) {
        $category_item->advcnt = 0;
      }
    }
    if ($category->parent) {
      $category->parent->advcnt = 0;
      $category->parent->childs = $category->parent->getAdChildss();
      foreach ($category->parent->childs as $category_item) {
        $category_item->advcnt = 0;
      }
    } 
    */    

    $category_fields = AdCategoriesFieldsQuery::create()
                        ->filterByCategoryId(array($category->getParentId(),$category->getId()))
                        ->filterByDeleted(false)
                        ->filterByEnabled(true)
                        ->filterByShowInTable(true)
                        ->find();
    $cc_fields = array(
      'name',
      'price',
      'publish_date',
      'Regions.Name',
      'AdvImages.Id');
    foreach ($category_fields as $ccategory_field) {
      $cc_fields[] = 's_' . $ccategory_field->getId();
    }

    $all_fields = AdCategoriesFieldsQuery::create()
      ->filterByCategoryId(array($category->getParentId(), $category->getId()))
      ->filterByDeleted(false)
      ->filterByEnabled(true)      
      ->orderBySort()
      ->join('AdCategoriesFieldsValues', Criteria::LEFT_JOIN)
      ->orderBy('AdCategoriesFieldsValues.Sort','asc')      
      ->find();
      
    $all_fields_ids = array();

    $colors = array();
    foreach ($all_fields as $all_field) {
      $all_fields_ids[] = $all_field->getId();
      $all_field_values = $all_field->getAdCategoriesFieldsValuess();
      foreach ($all_field_values as $all_field_value) {
        if ($all_field_value->getColor()) {
          $colors[$all_field_value->getName()] = array('id'=>$all_field->getId(),'value'=>$all_field_value->getId(),'color'=>$all_field_value->getColor());
        }
      }
    }

    # Вид
    $view = @$_SESSION['view'] ? $_SESSION['view'] : 'line';
    $type = @$_SESSION['type'] ? $_SESSION['type'] : 'all';
    $onpage = @$_SESSION['onpage'] ? $_SESSION['onpage'] : '24';
    $new = @$_SESSION['new'] ? $_SESSION['new'] : '1000';
    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'hide';

    # Сортировка
    $sort = @$_SESSION['sort'] ? $_SESSION['sort'] : 'UpDate';
    if (!in_array($sort, $cc_fields)) $sort = 'UpDate';
    $direction = @$_SESSION['direction'] == 'asc' ? 'asc' : 'desc';
    $page = @$_SESSION['page'] ? $_SESSION['page'] : '1';
    $data_sort = @explode("_", $sort);
    if (@$data_sort[0] == 's' && @$data_sort[1]) {
      $param = $data_sort[1];
    }

    # Фильтр
    $price_array = array();
    $filter_array_id = array();
    $filter_array_value = array();
    $filter_array_between = array();

    # -------- Объявления -----------
    # Поля категории
    $fields = array();
    
    /*
    foreach ($category_fields as $category_field) {
      $fields[$category_field->getId()] = $category_field;
    }
    */

    $category_array = array();
    $category_array[] = $category->getId();
    if ($category->getAdChildss())
      foreach ($category->getAdChildss() as $category_child)
      {
        $category_array[] = $category_child->getId();
      }     

    $allfields = array();

    foreach ($all_fields as $all_field)
    {
      if ($all_field->getType() != 5)
      {
        $allfields[$all_field->getId()] = array(
          'id' => $all_field->getId(),
          'name' => $all_field->getFilterName(),
          'postfix' => $all_field->getPostfix());
      }
    }

    # Поля категории списком
    $listing = array();
    $all_fields_ids= array_unique($all_fields_ids);
    
    $title_name = '';
    $filter_ids = array();
    $filter = array();
    $filter_breadcrumb = array();
    
    if ($parametr_1) {
      $filter_field = AdCategoriesFieldsValuesQuery::create()
                            ->filterByFieldId($all_fields_ids)
                            ->findOneByAlias($parametr_1);
      if ($filter_field) {
        $filter[$filter_field->getFieldId()] = $filter_field->getId();
        if ($filter_field->getTitle()) {
          $title_name .= $filter_field->getTitle().' '.mb_strtolower($category->getName(), 'UTF-8');
          $filter_breadcrumb[$filter_field->getAlias()] = $filter_field->getTitle();
          $filter_ids[] = $filter_field->getFieldId();
        }          
      }
    }
    if ($parametr_2) {
      $filter_field = AdCategoriesFieldsValuesQuery::create()
                            ->filterByFieldId($all_fields_ids)
                            ->findOneByAlias($parametr_2);
      if ($filter_field) {
        $filter[$filter_field->getFieldId()] = $filter_field->getId();
        if ($filter_field->getTitle()) {
          $title_name .= ' '.$filter_field->getTitle();
          $filter_breadcrumb[$filter_field->getAlias()] = $filter_field->getTitle();
          $filter_ids[] = $filter_field->getFieldId();
        }
      }
    }
    if ($parametr_3) {
      $filter_field = AdCategoriesFieldsValuesQuery::create()
                            ->filterByFieldId($all_fields_ids)
                            ->findOneByAlias($parametr_3);
      if ($filter_field) {
        $filter[$filter_field->getFieldId()] = $filter_field->getId();
        if ($filter_field->getTitle()) {
          $title_name .= ' '.$filter_field->getTitle();
          $filter_breadcrumb[$filter_field->getAlias()] = $filter_field->getTitle();
          $filter_ids[] = $filter_field->getFieldId();
        }
      }
    }
    
    if ($title_name) $page_title = $title_name.' без посредников';
    if ($title_name) $h1 = $title_name;
    $filter_ids = array_unique($filter_ids);
    $filter = array_unique($filter);
    
    
    foreach ($all_fields as $category_field)
    {
      if ($category_field->getListing() && $category->getParentId() && !in_array($category_field->getId(),$filter_ids))
      {        
        $listings = $category_field->getAdCategoriesFieldsValuess();
        $listing[$category_field->getId()]['id'] = $category_field->getId();        
        foreach ($listings as $list)
        {
          $listing[$category_field->getId()]['values'][($parametr_1?$parametr_1.'/':'').($parametr_2?$parametr_2.'/':'').$list->getAlias()] = $list->getTitle();
        }
        if (is_array(@$listing[$category_field->getId()]['values'])) asort($listing[$category_field->getId()]['values']);
      }
    }  

    //var_dump($listing);

    #####     Выборка объявлений (Большой запрос)

    $advs_query = AdvsQuery::create('Advs');	
    $advs_query->filterByCategoryId($category_array);

    $advs_query->join('Regions', Criteria::LEFT_JOIN);
    $advs_query->withColumn('Regions.Name', 'city');
    
    $advs_query->join('AdvImages', Criteria::LEFT_JOIN);
    $advs_query->withColumn('AdvImages.Id', 'photo');
    $advs_query->withColumn('AdvImages.Thumb', 'thumb');
    $advs_query->groupBy('Id');        

    # Сортировка
    $advs_query->join('AdvParams Params', Criteria::LEFT_JOIN);
    if (@$param) {
      $advs_query->where('Params.FieldId  = ?', $param);
      $advs_query->join('Params.AdCategoriesFieldsValues Values', Criteria::LEFT_JOIN);
      $advs_query->withColumn('Values.Name', $sort);
      $advs_query->withColumn('Params.TextValue', 'text_' . $sort);
    }    
    # Фильтр
    $filterWhere = '';
    if ($filter) {            
      foreach ($filter as $key => $filter_array_id_item) {        
        if (is_array($filter_array_id_item)) {
          $filter_array_id_item = array_unique($filter_array_id_item);
          $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.implode(',', $filter_array_id_item).'), 1, 0)) = 1';
        } else {          				
          $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.$filter_array_id_item.'), 1, 0)) = 1';
        }                
      }
    }
    if ($filterWhere){
      $advs_where = AdvParamsQuery::create('Params')
          ->join('Params.AdCategoriesFieldsValues Values',Criteria::LEFT_JOIN)
          ->select('adv_id')
          ->groupBy('adv_id')
          ->having(implode(' AND ', $filterWhere))
          ->find();
      $advs_query->where('Advs.Id IN ?', $advs_where);
    }
    # ------
    $advs_query->orderBy($sort, $direction);
    if (@$param) {
      $column = 'text_' . $sort;
      if ($direction == 'asc') {
        $advs_query->addAscendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
      } else{
        $advs_query->addDescendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
      }
    }

    # Комментарии
    $advs_query->join('AdvComments', Criteria::LEFT_JOIN);
    $advs_query->orderBy('AdvComments.Date', 'asc');
	
    # Изменение цены
    $advs_query->join('AdvPrice', Criteria::LEFT_JOIN);
    $advs_query->orderBy('AdvPrice.Date', 'asc');
    
    $advs_query->orderBy('AdvImages.Id');	
    $advs_query->filterByArray(array('enabled' => true, 'deleted' => false));
    $advs_query->join('AdvPackets', Criteria::LEFT_JOIN);   
    
    
    $aadvs_query = clone $advs_query;
    $radvs_query = clone $advs_query;
    $p_query = clone $advs_query;
    $l_query = clone $advs_query;
    
      
    // Объявления рубрики (город)
    $aadvs_query->where('AdvPackets.PacketId = ?', 3);
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all'){
      $aadvs_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    } elseif (@$_SESSION['area']){
      $aadvs_query->where('Advs.AreaId = ?', $_SESSION['area']->getId());
    } 
    $paginator = $this->get('knp_paginator');
    
    $pagination = $paginator->paginate($aadvs_query, $this->get('request')->query->get('page', 1), $onpage);    
    
    
    
    // Объявления рубрики (регион)
    if (!$pagination->getTotalItemCount()) {
      $radvs_query = $advs_query->where('AdvPackets.PacketId = ?', 3);    
      if (@$_SESSION['region'] && $_SESSION['region'] != 'all') {
        $radvs_query->where('Advs.AreaId = ?', $_SESSION['region']->getAreaId());
      }
      if (@$_SESSION['area']) {
        $radvs_query->where('Advs.AreaId = ?', $_SESSION['area']->getId());
      }   		
      $r_pagination = $paginator->paginate($radvs_query, $this->get('request')->query->get('page', 1), $onpage);
    }	
    
    // Premium
    $p_query->where('AdvPackets.Paid = ?', true);	
    $p_query->where('AdvPackets.PacketId = ?', 1);
    $p_query->where('AdvPackets.UseBefore >= ?', strtotime( date("Y-m-d H:i:s") ) );
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all'){
      $p_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    } elseif (@$_SESSION['area']){
      $p_query->where('Advs.AreaId = ?', $_SESSION['area']->getId());
    } 
    
    $premium_pagination = $paginator->paginate($p_query, $this->get('request')->query->get('page', 1), 2);	
    
    // Lite
    $l_query->where('AdvPackets.Paid = ?', true);	
    $l_query->where('AdvPackets.PacketId = ?', 2);
    $l_query->where('AdvPackets.UseBefore >= ?', strtotime( date("Y-m-d H:i:s") ) );
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all'){
      $l_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    } elseif (@$_SESSION['area']){
      $l_query->where('Advs.AreaId = ?', $_SESSION['area']->getId());
    } 
    
    $lite_pagination = $paginator->paginate($l_query, $this->get('request')->query->get('page', 1), 2);    
	
    ##### 
      
    # Вы смотрели
    $yadvs = array();
    if (@$_SESSION['viewed_advs']) $yadvs = AdvsQuery::create()->filterById($_SESSION['viewed_advs'])->find();

    # VIP объявления
    $vip_advs_query = AdvsQuery::create('Advs');
    $vip_advs_query->filterByCategoryId($category_array);
    $vip_advs_query->join('Regions', Criteria::LEFT_JOIN);
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all')
    {
      $vip_advs_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    }
    $vip_advs_query->join('AdvPackets', Criteria::LEFT_JOIN);
    $vip_advs_query->where('AdvPackets.PacketId = ?', 1);
    $vip_advs_query->where('AdvPackets.Paid = ?', 1);
    $vip_advs_query->where('AdvPackets.UseBefore >= ?', strtotime(date("Y-m-d H:i:s")));    
    $vip_advs = $vip_advs_query->filterByArray(array('enabled' => true, 'deleted' => false))->find();
    
    # Случайные VIP
    $cnt = 2;  // Количество VIP объявлений
    if (count($vip_advs)) {
      $vip_array = $vip_advss = $rand = array();
      foreach ($vip_advs as $vip_adv) {
        $vip_array[] = $vip_adv;
      }
      if (count($vip_array)<$cnt) $cnt = count($vip_array);
      $rand = array_rand($vip_array,$cnt);
      if (is_array($rand)) {
        foreach ($rand as $rand_item) {
          $vip_advss[] = $vip_array[$rand_item];
        }
      } else {
        $vip_advss[] = $vip_array[$rand];
      }
    } else {
      $vip_advss = $vip_advs;
    }
    
    # Подписка на новые объявления
    $subscribe = new AdCategoriesSubscribe();
    $subscribe->setCategoryId($category->getId());
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all') {
      $subscribe->setTownId($_SESSION['region']->getId());
      $subscribe->setAreaId($_SESSION['region']->getAreaId());
    } elseif (@$_SESSION['area']) {
      $subscribe->setAreaId($_SESSION['area']->getId());
    }
    $data = array();
    $data['subscribe'] = $subscribe;
    if ($user != 'anon.') { $data['user'] = $user; $subscribe->setEmail($user->getEmail());} else { $data['user'] = NULL; };
      $subscribe_form = $this->createForm(new Subscribe(), $data);
      $subscribe_form->handleRequest($request);	

      if ($subscribe_form->isValid())
      {      
      # Проверяем правильность Email
      $email = $request->request->get('email');
      if (!$email) {
        $this->get('session')->getFlashBag()->add(
              'alertsite',
              'Вы не указали свой Email');
      } else {
        $emailConstraint = new EmailConstraint();
        $emailConstraint->message = 'Неверный формат Email адреса';
        $errors = $this->get('validator')->validateValue(
          $email,
          $emailConstraint 
        );		
        if ($errors->count()) {
          if (@$errors[0]->getMessage()) {			
            $this->get('session')->getFlashBag()->add(
                'alertsite',
                $errors[0]->getMessage());
          }
        } else {
          # Проверяем не была ли уже оформлена подписка
          $subscribe_test_q = AdCategoriesSubscribeQuery::create();
            $subscribe_test_q->filterByCategoryId($subscribe->getCategoryId());
            if (@$_SESSION['region']) {
              $subscribe_test_q->filterByTownId($_SESSION['region']->getId());
              $subscribe_test_q->filterByAreaId($_SESSION['region']->getAreaId());
            } elseif (@$_SESSION['area']) {
              $subscribe_test_q->filterByAreaId($_SESSION['area']->getId());
            }			
            $subscribe->setEmail($request->request->get('email'));
            $subscribe_test_q->filterByEmail($subscribe->getEmail());
            $subscribe_test = $subscribe_test_q->findOne();
          if (!$subscribe_test) {		
            # Фиксируем последнее объявление на текущий момент в данной рубрике
            $last_advs_query = AdvsQuery::create('Advs');
            $last_advs_query->filterByCategoryId($category_array);
            $last_advs_query->join('Regions', Criteria::LEFT_JOIN);
            $last_advs_query->join('Areas', Criteria::LEFT_JOIN);
            if (@$_SESSION['region'] && $_SESSION['region'] != 'all') {
              $last_advs_query->where('Regions.Id = ?', $_SESSION['region']->getId());
            } elseif (@$_SESSION['area']) {
              $last_advs_query->where('Areas.Id = ?', $_SESSION['area']->getId());
            }
            $last_advs_query->orderById('DESC');
            $last_advs = $last_advs_query->filterByArray(array('enabled' => true, 'deleted' => false))->findOne();
            if ($last_advs) {
              $subscribe->setLastAdvId($last_advs->getId());
            } else {
              $subscribe->setLastAdvId(0);
            }
            $subscribe->setUnsubscribeCode(uniqid());			
            $subscribe->save();
            $this->get('session')->getFlashBag()->add(
                'noticesite',
                'Подписка на новые объявления успешно оформлена');

            $subscribe = new AdCategoriesSubscribe();
            $subscribe->setCategoryId($category->getId());
            if (@$_SESSION['region'] && $_SESSION['region'] != 'all') {
              $subscribe->setTownId($_SESSION['region']->getId());
              $subscribe->setAreaId($_SESSION['region']->getAreaId());
            } elseif (@$_SESSION['area']) {
              $subscribe->setAreaId($_SESSION['area']->getId());
            }
            $data = array();
            $data['subscribe'] = $subscribe;
            if ($user != 'anon.') { $data['user'] = $user; } else { $data['user'] = NULL; };
            $subscribe_form = $this->createForm(new Subscribe(), $data);
          } else {
            $this->get('session')->getFlashBag()->add(
                'alertsite',
                'Подписка уже оформлена');
          }
        }
      }
    }
	
	  
    $response = new Response();	
    $response->headers->addCacheControlDirective('no-store', true);
    $response->headers->addCacheControlDirective('no-cache', true);
    $response->headers->addCacheControlDirective('must-revalidate', true);
    $response->headers->addCacheControlDirective('post-check', 0);
    $response->headers->addCacheControlDirective('pre-check', 0);
    if (@$advs[0]) {
      $response->setLastModified($advs[0]->getPublishDate());
    }
	
    return $this->render('SiteFirstPageBundle:Default:category.html.twig', array(
      'title' => $page_title,
      'h1' => $h1,
      'description' => $page_description,
      'text' => $page_text,
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_search' => $banner_search,
      'banner_right' => $banner_right,
      'banner_bottom' => $banner_bottom,
      'top_panel' => $top_panel,
      'search_form' => $search_form->createView(),
      'subscribe_form' => $subscribe_form->createView(),
      'subscribe_status' => @$_SESSION['subscribe_form']?:'show',
      'category' => $category,
      'filter_breadcrumb' => $filter_breadcrumb,
      'view' => $view,
      'type' => $type,
      'onpage' => $onpage,
      'new' => $new,
      'filt' => $filt,
      'sort' => $sort,
      'dir' => $direction,
      'page' => $page,
      'fields' => $fields,
      'listing' => $listing,
      'listing_name' => @$listing_name?:'',
      'listing_id' => @$listing_id?:'',
      'allfields' => $allfields,
      'advs' => $pagination,
      'r_advs' => @$r_pagination?:NULL,
      'p_advs' => @$premium_pagination?:NULL,
      'l_advs' => @$lite_pagination?:NULL,
      'yadvs' => $yadvs,
      'vip_advs' => $vip_advss,
      'user' => $user,
      'menu' => $menu,
      'colors' => $colors),$response);
  } 
  
  function seo($text,$top_panel){
    $text = preg_replace('/{in}/ix', $top_panel['in_town'], $text);
    $text = preg_replace('/{net}/ix', $top_panel['net_town'], $text);
    // Подчищаем
    $text = preg_replace('/[\s]{2,}/', ' ', $text);
    $text = preg_replace('/[\s]\./', '.', $text);
    $text = preg_replace('/[\s]\,/', ',', $text);
    return $text;
  }
  
}
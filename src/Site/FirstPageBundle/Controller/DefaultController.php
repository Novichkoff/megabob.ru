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
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\Partners;
use Admin\AdminBundle\Model\PartnersQuery;
use Admin\AdminBundle\Model\SettingsQuery;
use Admin\AdminBundle\Model\TransactionsQuery;
use Admin\AdminBundle\Model\UserAccount;
use FOS\UserBundle\Propel\UserQuery;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Eko\FeedBundle\Field\Item\MediaItemField;
use Symfony\Component\HttpFoundation\Response;
use Eko\FeedBundle\Field\Item\ItemField;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DefaultController extends Controller
{	
	
  public function partnerAction(Request $request)
  {   
    $partner_id = @$request->query->get('partner_id');
    if (@$partner_id) $user = UserQuery::create()->findOneById($partner_id);   
    
    if (@$user) {      
      $useragent = $_SERVER['HTTP_USER_AGENT'];
      $referer = @$_SERVER['HTTP_REFERER'];
      if(@$referer) $domain = parse_url($referer);        
      $mdomains = array('e.mail.ru','mail.yandex.ru','www.google.ru','www.google.com','googleads.g.doubleclick.net','www.megabob.ru');
      if (@$domain && !in_array($domain,$mdomains)) {
        # Отсеиваем ботов
        if (!preg_match("/bot/i", $useragent)) {
          $user->setPartnerVisits($user->getPartnerVisits()+1);
          if ($user->getPartnerVisits() >= 1000) {
            $transaction = new Transactions();
            $transaction->setEmail('partner@megabob.ru');
            $transaction->setSum(100);
            $transaction->setFosUserId($user->getId());
            $transaction->setType('Партнерский Бонус');
            $transaction->setTransactionDate(date("Y-m-d H:i:s"));
            $transaction->save();
            $account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
            if (!$account) {
              $account = new UserAccount;
              $account->setFosUserId($user->getId());
            }
            $account->setBalance($account->getBalance() + 100);
            $account->save();
            $user->setPartnerVisits(1);
          }
          $user->save();
          
          $partners = PartnersQuery::create()->filterByFosUserId($user->getId())->filterBySite($domain["host"])->findOne();
          if (!$partners) {
            $partners = new Partners();
            $partners->setFosUserId($user->getId());
            $partners->setSite($domain["host"]);
            $partners->setCnt(1);
          } else {
            $partners->setCnt($partners->getCnt()+1);
          }                    
          $partners->save();
        }        
      }
    }    
    $file = 'images/partner.png';
    $response = new BinaryFileResponse($file);    
    return $response;
  }
  
  public function robotsAction(Request $request)
  {

    $settings = SettingsQuery::create()->findOne();

    return $this->render('SiteFirstPageBundle:Default:robots.html.twig', array
      ('robots' => $settings->getRobots()));
  }
  
  public function adsAction(Request $request)
  {
	$file = 'ads.txt';
    $response = new BinaryFileResponse($file);    
    return $response;
    
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
  
  public function wellAction(Request $request)
  {

    return new Response('aEIRE_ecm-YTsX_DDclrRNK5mx0qdWj5surAbcjjI5E.r-mNm6m8N78tueeTh3bAVLDOJQslG09v1993hHB4Aag');
  }
  
  public function allRegionsAction(Request $request)
  {

    $towns = RegionsQuery::create()->filterByType(array(1, 2))->find();

    return $this->render('SiteFirstPageBundle:Default:all_regions.html.twig', array
      ('towns' => $towns));
  }
  
  public function setSessionAction(Request $request)
  {

    $data = $request->request->all();
    foreach ($data as $key=>$value) {
      $_SESSION[$key] = $value;
    }

    return new Response();
  }
  
  public function allAreasMapAction(Request $request)
  {

    $areas = AreasQuery::create()->orderByName()->find();	
    $all_areas = array();
    $all_areas[1] = array();
    $all_areas[2] = array();	
    foreach ($areas as $area) {
      $all_areas[$area->getPart()][] = array(
        'id' 		=> $area->getId(),
        'alias'		=> $area->getAlias(),
        'path'		=> $area->getPath(),
        'name'		=> $area->getName(),
        'pagetitle'	=> $area->getNet()
      );      
    }   

    return new Response(json_encode($all_areas));
  }
    
  ######################################
  # Все названия объявлений для поиска #
  ######################################
  public function allAdvsAction(Request $request)
  {

    $town_array = array();
    $category_id = @$_SESSION['search_category'] ? : null;
    $search_query = $request->request->all();
    if ($search_query['area'] && $search_query['area']!='all')
    {
      $area = AreasQuery::create()->filterById($search_query['area'])->findOne();
      $towns_query = RegionsQuery::create();
      $towns_query->filterByAreaId($area->getId());
      if ($search_query['town'] && $search_query['town']!='all')
      {
        $towns_query->filterById($search_query['town']);
      }
      $towns = $towns_query->find();
      foreach ($towns as $town)
      {
        $town_array[] = $town->getId();
      }
    }
    
    $advs_query = AdvsQuery::create('Advs');
    if ($category_id)
    {
      $category = AdCategoriesQuery::create()->filterById($category_id)->findOne();
      $category_array = array();
      $category_array[] = $category_id;
      if ($category->getAdChildss())
        foreach ($category->getAdChildss() as $category_child)
        {
          $category_array[] = $category_child->getId();
        }
      $advs_query->filterByCategoryId($category_array);
    }
    
    if (@$search_query['sq']) {
      $text = $search_query['sq'];
      $advs_query->where('lower(Advs.Name) like lower(?)', '%'.$text.'%');
      $advs_query->orWhere('lower(Advs.Description) like lower(?)', '%'.$text.'%');      
    }
    if ($town_array) $advs_query->filterByRegionId($town_array);
    $advs_query->filterByDeleted(false);
    $advs_query->filterByEnabled(true);
    $advs = $advs_query->find();
    $all_advs = array();
    foreach ($advs as &$adv)
    {
      $all_advs[] = $adv->getName();
    }
    return new Response(json_encode($all_advs));
  }

  #######################################################
  ###             Все объявления на карте             ###
  #######################################################
  public function allAdvsOnMapAction(Request $request)
  {

    # Получаем строку поиска
    $search_query = $request->query->all();
    $category_id = $search_query['cid'];
    $sq = @$search_query['sq'] ? : null;
    $im = @$search_query['im'] ? : null;
    unset($search_query['cid']);
    unset($search_query['im']);
    unset($search_query['sq']);

    # Фильтр
    $price_array = array();
    $filter_array_id = array();
    $filter_array_value = array();
    $filter_array_between = array();

    foreach ($search_query as $key => $value)
    {
      if ($value)
      {
        if ($key == 'sp_from' || $key == 'sp_to')
        {
          $price_array[$key] = $value;
        }
        elseif (is_numeric($value))
        {
          $var = @explode("_", $key);
          if (@$var[1])
          {
            $filter_array_id[$var[1]] = $value;
          }
        }
        else
        {
          $var = @explode("_", $key);
          $array = @explode("-", $value);
          if (@$array[0] && @$array[1])
          {
            if (@$var[1])
            {
              $filter_array_between[$var[1]] = $array;
            }
          }
          elseif (@$array[0] != "" && @$array[1] != "")
          {
            if (@$var[1])
            {
              $filter_array_value[$var[1]] = $value;
            }
          }
        }
      }
    }

    # Все названия объявлений для поиска
    $advs_query = AdvsQuery::create('Advs');
    $advs_query->filterByCategoryId($category_id);
    $advs_query->filterByDeleted(false);
    $advs_query->filterByEnabled(true);
    if ($sq) $advs_query->filterByText($sq);
    if ($im) $advs_query->joinWith('AdvImages');
    $advs_query->joinWith('AdvParams Params', Criteria::LEFT_JOIN);
    # Фильтр
    if (@$price_array['sp_from']) $advs_query->where('Advs.Price > ?', $price_array['sp_from']);
    if (@$price_array['sp_to']) $advs_query->where('Advs.Price < ?', $price_array['sp_to']);
    $filterWhere = '';
    if ($filter_array_id)
    {
      foreach ($filter_array_id as $key => $filter_array_id_item)
      {
        $filterWhere[] = 'MAX(IF(Params.FieldId = ' . $key . ' AND Params.ValueId IN (' .
          implode(',', $filter_array_id) . '), 1, 0)) = 1';
      }
    }
    if ($filter_array_value)
    {
      foreach ($filter_array_value as $key => $filter_array_id_item)
      {
        $filterWhere[] = 'MAX(IF(Params.FieldId = ' . $key .
          ' AND Params.TextValue IN (' . implode(',', $filter_array_value) .
          '), 1, 0)) = 1';
      }
    }
    if ($filter_array_between)
    {
      foreach ($filter_array_between as $key => $filter_array_id_item)
      {
        $filterWhere[] = '(MAX(IF(Params.FieldId = ' . $key .
          ' AND Params.TextValue between ' . $filter_array_id_item[0] . ' and ' . $filter_array_id_item[1] .
          ', 1, 0)) = 1 OR MAX(IF(Params.FieldId = ' . $key . ' AND Values.Name between ' .
          $filter_array_id_item[0] . ' and ' . $filter_array_id_item[1] . ', 1, 0)) = 1)';
      }
    }

    if ($filterWhere)
    {
      $advs_where = AdvParamsQuery::create('Params')->join('Params.AdCategoriesFieldsValues Values',
        Criteria::LEFT_JOIN)->select('adv_id')->groupBy('adv_id')->having(implode(' AND ',
        $filterWhere))->find();

      $advs_query->where('Advs.Id IN ?', $advs_where);
    }
    $advs = $advs_query->find();
    $resp = array();
    $resp["type"] = "FeatureCollection";
    $resp["features"] = array();
    foreach ($advs as &$adv)
    {
      if ($adv->getCoord())
      {
        $coordinates = explode(',', $adv->getCoord());
        foreach ($coordinates as &$coordinate)
        {
          $coordinate = floatval($coordinate);
        }
        $color = 'blue';
        foreach ($adv->getAdvParamss()->getData() as $param)
        {
          if (@$param->getAdCategoriesFieldsValues() && @$param->
            getAdCategoriesFieldsValues()->getColor()) $color = $param->
              getAdCategoriesFieldsValues()->getColor();
        }
        if ($coordinates[0] && $coordinates[1]) $all_advs[] = array(
          "type" => "Feature",
          "id" => $adv->getId(),
          "geometry" => array("type" => "Point", "coordinates" => $coordinates),
          "properties" => array(
            "balloonContent" => (@$adv->getAdvImagess()[0] ?
              '<img width="120" class="pull-left padding-5" src="/images/a/images/' . $adv->
              getAdvImagess()[0]->getThumb() . '">' : '') . $adv->getName() .
              '<br><strong class="line_price red padding-5 text-nowrap">' . ($adv->getPrice() ? number_format($adv->getPrice(), 0, ',', ' ').' <i class="fa fa-rub"></i>' : ($adv->getDogovor() ? 'Договорная' : 'Бесплатно')) .
              '</strong><br><a class="btn btn-xs btn-default" target="_blank" href="' . $this->generateUrl('site_adv_page', array('category' => $adv->getAdCategories()->getAdCategoriesRelatedByParentId()->getAlias(), 'subcategory' => $adv->getAdCategories()->getAlias(), 'alias' => $adv->getAlias(), 'region' => $adv->getRegions()->getAlias(), 'id' => $adv->getId())) .
              '">подробнее</a>',
            "hintContent" => $adv->getName(),
            "clusterCaption" => $adv->getId()),
          "options" => array("preset" => "islands#".$color."CircleDotIcon"));
      }
    }
    $resp["features"] = $all_advs;
    return new Response(json_encode($resp));
  }

  ##################################################
  #                   Карта сайта                  #
  ##################################################

  public function sitemapListAction($area = 'all', $region = 'russia', Request $request)
  {

    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    $banner_top = $this->get('banner')->select($zone = 1, $request);
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 3, $request);
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

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $search_form = $this->createForm(new SimpleSearchType());

    $menu = MenuQuery::create()->find();

    $req = $request->query->all();
    if ($category_id = @$req['c_id'])
    {
      $category = AdCategoriesQuery::create()->filterById($category_id)->find();
    }

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    #---------------------------------------------------------------------------------
    # Категории на главной
    $categories_onmain = AdCategoriesQuery::create()
      //->joinWith('AdChilds Childs',Criteria::LEFT_JOIN)
      ->orderById()->filterByParentId(null)->filterByDeleted(false)->find();

    $category = new AdCategories();
    $category->setCatchPhrase('Доска объявлений MegaBob.ru');

    if ($area != 'all')
    {
      $area_select = AreasQuery::create()->filterByAlias($area)->findOne();
    }

    # Города на главной
    if (@$area_select)
    {
      $regions_query = RegionsQuery::create();
      $regions_query->filterByDeleted(false);
      $regions_query->filterByAreaId($area_select->getId());
      if ($region != 'russia')
      {
        $regions_query->filterByAlias($region);
      }
      $regions_query->orderByType();
      $regions_query->orderByName();
      $regions = $regions_query->find();
    }

    if ($region != 'russia')
    {
      $region_select = RegionsQuery::create()->filterByAlias($region)->findOne();
    }

    # Области
    $areas = AreasQuery::create()->filterByDeleted(false)->orderByName()->find();

    return $this->render('SiteFirstPageBundle:Default:sitemap.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => $banner_top,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_right' => $banner_right,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'area' => $area,
      'region' => $region,
      'area_select' => @$area_select ? : null,
      'region_select' => @$region_select ? : null,
      'towns' => @$regions ? : null,
      'areas' => $areas,
      'search_form' => $search_form->createView(),
      'categories' => $categories_onmain,
      'category' => $category,
      'menu' => $menu));
  }
  
  ##################################################
  #                   Поиск Яндекса                #
  ##################################################

  public function yandexSearchAction(Request $request)
  {

    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    $banner_top = $this->get('banner')->select($zone = 1, $request);
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 3, $request);
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

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $search_form = $this->createForm(new SimpleSearchType());

    $menu = MenuQuery::create()->find();

    $req = $request->query->all();
    if ($category_id = @$req['c_id'])
    {
      $category = AdCategoriesQuery::create()->filterById($category_id)->find();
    }

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    #---------------------------------------------------------------------------------
    
    return $this->render('SiteFirstPageBundle:Default:yandex_search.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => $banner_top,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_right' => $banner_right,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'area' => $area,
      'region' => $region,
      'area_select' => @$area_select ? : null,
      'region_select' => @$region_select ? : null,
      'towns' => @$regions ? : null,
      'areas' => $areas,
      'search_form' => $search_form->createView(),
      'categories' => $categories_onmain,
      'category' => $category,
      'menu' => $menu));
  }

  ##################################################
  #               Начальная страница               #
  ##################################################

  public function indexAction(Request $request)
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

    $menu = MenuQuery::create()->find();

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();    

    #---------------------------------------------------------------------------------
    			
    $response = new Response();	

    $response = $this->render('SiteFirstPageBundle:Default:index.html.twig', array(
      'last_username' => $lastUsername,
      'error'         => $error,
      'csrf_token'    => $csrfToken,
      'top_panel'     => $top_panel,
      'search_form'   => $search_form->createView(),
      'menu'          => $menu));

    $response->headers->addCacheControlDirective('must-revalidate', true);

    $response->setETag(md5($response->getContent()));
    $response->setPublic();	

    return $response;
  }

  ###############################################
  ##              Дайджест                     ##
  ###############################################
  public function digestAction(Request $request)
  {
    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    $banner_top = $this->get('banner')->select($zone = 1, $request);
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 3, $request);
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

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';

    $search_form = $this->createForm(new SimpleSearchType());

    $menu = MenuQuery::create()->find();

    $req = $request->query->all();
    if ($category_id = @$req['c_id'])
    {
      $category = AdCategoriesQuery::create()->filterById($category_id)->find();
    }

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    #---------------------------------------------------------------------------------
    # Категории на главной
    $categories_onmain = AdCategoriesQuery::create()->join('AdChilds Childs',
      Criteria::LEFT_JOIN)->orderBySort()->groupById()->filterByParentId(null)->filterByDeleted(false)->
      find();

    $category = new AdCategories();
    $category->setCatchPhrase('Бесплатные объявления MegaBob');

    # Города на главной
    if (@$_SESSION['area'])
    {
      $regions = RegionsQuery::create()->filterByDeleted(false)->filterByAreaId($_SESSION['area']->
        getId())->orderByType()->orderByName()->find();
    }
    else
    {
      $regions = RegionsQuery::create()->filterByDeleted(false)->filterByType(array('1',
          '2'))->orderByType()->orderByName()->find();
    }

    # Города на главной
    $areas = AreasQuery::create()->filterByDeleted(false)->orderByName()->find();

    # Все объявления
    $all_advs_query = AdvsQuery::create('Advs');
    $all_advs_query->join('Regions', Criteria::LEFT_JOIN);
    if ($_SESSION['region'])
    {
      $all_advs_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    }
    $all_advs = $all_advs_query->filterByArray(array(
      'moderApproved' => true,
      'enabled' => true,
      'deleted' => false))->find();

    # Дайджест
    $last_advs_query = AdvsQuery::create('Advs');
    $last_advs_query->join('Regions', Criteria::LEFT_JOIN);
    if ($_SESSION['region'])
    {
      $last_advs_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    }
    $last_advs_query->filterByDigest(true);
    $last_advs_query->orderByCreateDate('desc');
    $last_advs_query->join('AdvImages', Criteria::LEFT_JOIN);
    $last_advs_query->groupById();
    $last_advs = $last_advs_query->filterByArray(array(
      'moderApproved' => true,
      'enabled' => true,
      'deleted' => false))->find();
    $digest_advs_count = 0;
    $digest_advs = array();
    foreach ($last_advs as $d_adv)
    {
      if ($digest_advs_count++ < 120) array_push($digest_advs, $d_adv);
    }

    return $this->render('SiteFirstPageBundle:Default:digest.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => $banner_top,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_right' => $banner_right,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'all_advs' => $all_advs,
      'digest_advs' => $digest_advs,
      'towns' => $regions,
      'areas' => $areas,
      'search_form' => $search_form->createView(),
      'categories_onmain' => $categories_onmain,
      'category' => $category,
      'menu' => $menu));
  }

  #####################################################
  #                 Обновление поиска                 #
  #####################################################

  public function search_form_updateAction(Request $request)
  {

    $form_req = $request->request->all();
    $category = AdCategoriesQuery::create()->filterById($form_req['cid'])->findOne();
	if (@$form_req['area']) {
		if ($form_req['area']=='all') {
			$_SESSION['area'] = NULL;
			$_SESSION['url_region'] = 'russia';
		} else {
			$_SESSION['find_area'] = $form_req['area'];
			$_SESSION['area'] = AreasQuery::create()
					->filterByArray(array('deleted'=>0,'id'=>$form_req['area']))              
					->findOne();
			if ($_SESSION['area']) $_SESSION['url_region'] = $_SESSION['area']->getAlias();
		}		
	}
	if (@$form_req['region']) {
		$_SESSION['find_region'] = $form_req['region'];
		$_SESSION['region'] = RegionsQuery::create()
                ->filterByArray(array('deleted'=>0,'id'=>$form_req['region']))              
                ->findOne();
		if ($_SESSION['region']) $_SESSION['url_region'] = $_SESSION['region']->getAlias();
	}

    $search_form = $this->createForm(new SimpleSearchType(), $category);
    $search_form->handleRequest($request);
    $top_panel = $this->get('toppanel')->buildPanel($request);

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'show';	

    return $this->render('SiteFirstPageBundle:Default:advs_search_form.html.twig',
      array(
      'search_form' => $search_form->createView(),
      'filt' => $filt,
      'top_panel' => $top_panel,
      'category' => $category));
  }

  ############################################################################
  #                            Объявления пользователя                       #
  ############################################################################

  public function userAction($user_id, Request $request)
  {

    $session = $request->getSession();

    $t_user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' =>
        $user_id));
    if (!$t_user)
    {
      throw new NotFoundHttpException('Пользователь отсутствует!');
    }

    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    # ---- Баннеры ----
    $banner_top = $this->get('banner')->select($zone = 1, $request);
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 3, $request);
    $banner_right = $this->get('banner')->select($zone = 4, $request);
    $banner_bottom = $this->get('banner')->select($zone = 5, $request);

    # Формируем верхнюю панель
    $top_panel = $this->get('toppanel')->buildPanel($request);

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

    # Вид
    $view = @$_SESSION['view'] ? $_SESSION['view'] : 'line';
    $type = @$_SESSION['type'] ? $_SESSION['type'] : 'all';
    $onpage = @$_SESSION['onpage'] ? $_SESSION['onpage'] : '24';
    $new = @$_SESSION['new'] ? $_SESSION['new'] : 'all';

    # Сортировка
    $sort = @$_SESSION['sort'] ? $_SESSION['sort'] : 'id';
    $direction = @$_SESSION['direction'] == 'asc' ? 'asc' : 'desc';
    $page = @$_SESSION['page'] ? $_SESSION['page'] : '1';
    $data_sort = @explode("_", $sort);
    if (@$data_sort[0] == 's' && @$data_sort[1])
    {
      $param = $data_sort[1];
    }

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());
    #---------------------------------------------------------------------------------
    # Категория, дочерние, родительская и соседние категории
    # Выбор Категории объявления

    $search_form = $this->createForm(new SimpleSearchType());

    # -------- Объявления -----------

    #####     Выборка объявлений (Большой запрос)

    $advs_query = AdvsQuery::create('Advs');
    $advs_query->join('User');
    $advs_query->filterByUserId($user_id);
    $advs_query->join('Regions', Criteria::LEFT_JOIN);
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all')
    {
      $advs_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    }
    $advs_query->join('AdvImages', Criteria::LEFT_JOIN);
    $advs_query->withColumn('AdvImages.Thumb', 'thumb');
    $advs_query->join('User');    
    $advs_query->join('AdvPackets', Criteria::LEFT_JOIN);
    $advs_query->join('AdCategories', Criteria::LEFT_JOIN);

    $advs_query->joinWith('AdvParams Params', Criteria::LEFT_JOIN);
    $advs_query->join('Params.AdCategoriesFields', Criteria::LEFT_JOIN);
    $advs_query->join('Params.AdCategoriesFieldsValues', Criteria::LEFT_JOIN);

    $advs_query->orderBy('AdvImages.Id','DESC');
    $advs = $advs_query->filterByArray(array('enabled' => true, 'deleted' => false))->
      find();
    #####

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate($advs, $this->get('request')->query->get('page',
      1), $onpage);

    return $this->render('SiteFirstPageBundle:Default:user.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => $banner_top,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_right' => $banner_right,
      'banner_bottom' => $banner_bottom,
      'top_panel' => $top_panel,
      'search_form' => $search_form->createView(),
      'advs' => $pagination,
      'filt' => $filt,
      'view' => $view,
      'type' => $type,
      'onpage' => $onpage,
      'new' => $new,
      'sort' => $sort,
      'dir' => $direction,
      'fields' => array(),
      'allfields' => array(),
      'page' => $page,
      'user' => $user,
      't_user' => $t_user,
      'filt' => $filt,
      'menu' => $menu));
  }

  #####################################################
  #          Обновление городов                       #
  #####################################################

  public function region_updateAction(Request $request)
  {

    $id = $request->request->get('id');
    if ($id) {
      $_SESSION['area'] = AreasQuery::create()->filterById($id)->findOne();
      $regions = RegionsQuery::create()->filterByArray(array('deleted' => 0, 'areaId' => $id))->orderByType()->orderByName()->find();
    } else {
      $regions = null;
    }

    return $this->render('SiteFirstPageBundle:Default:region_update.html.twig',
      array('regions' => $regions, 'area' => $_SESSION['area']));
  }

  ##################################################
  #               Cтраница с магазинами            #
  ##################################################

  public function shopsAction(Request $request)
  {
    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    $banner_top = $this->get('banner')->select($zone = 1, $request);
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 3, $request);
    $banner_right = $this->get('banner')->select($zone = 4, $request);
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

    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::
      LAST_USERNAME);

    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'hide';

    $search_form = $this->createForm(new SimpleSearchType());

    $menu = MenuQuery::create()->find();

    $req = $request->query->all();
    if ($category_id = @$req['c_id'])
    {
      $category = AdCategoriesQuery::create()->filterById($category_id)->find();
    }

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    #---------------------------------------------------------------------------------
    # Магазины
    $shops_query = ShopsQuery::create();
    $shops_query->filterByEnabled(true);
    $shops_query->join('Advs', Criteria::LEFT_JOIN);
    $shops_query->groupBy('Advs.id');
    //$shops_query->having('count(Advs.id) >0');
    $shops_query->join('Regions', Criteria::LEFT_JOIN);
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all')
    {
      $shops_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    }	
    if (@$_SESSION['area'])
    {
      $shops_query->where('Regions.AreaId = ?', $_SESSION['area']->getId());
    }    
    $paginator = $this->get('knp_paginator');
    $shops = $paginator->paginate($shops_query, $this->get('request')->query->get('page',
      1), 10);

    $category = new AdCategories();
    $category->setCatchPhrase('Доска объявлений MegaBob.ru');
    
    # Вы смотрели
    $yadvs = array();
    if (@$_SESSION['viewed_advs']) $yadvs = AdvsQuery::create()->filterById($_SESSION['viewed_advs'])->find();


    return $this->render('SiteFirstPageBundle:Default:shops.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => $banner_top,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_right' => $banner_right,
      'banner_bottom' => $banner_bottom,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'search_form' => $search_form->createView(),
      'category' => $category,
      'shops' => $shops,
      'yadvs' => $yadvs,
      'user' => $user,
      'menu' => $menu));
  }

  ##################################################
  #        Cтраница с объявлениями магазина        #
  ##################################################

  public function shop_advsAction($alias, Request $request)
  {
    #---- Единая конфигурация -------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    #---- Баннеры --------
    $banner_top = $this->get('banner')->select($zone = 1, $request);
    $banner_search = $this->get('banner')->select($zone = 2, $request);
    $banner_advs = $this->get('banner')->select($zone = 3, $request);
    $banner_right = $this->get('banner')->select($zone = 4, $request);
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

    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::
      LAST_USERNAME);

    $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->
      get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

    $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'hide';

    $search_form = $this->createForm(new SimpleSearchType());

    $menu = MenuQuery::create()->find();

    $req = $request->query->all();
    if ($category_id = @$req['c_id'])
    {
      $category = AdCategoriesQuery::create()->filterById($category_id)->find();
    }

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();
    if ($user != 'anon.') $user->account = UserAccountQuery::create()->
        findOneByFosUserId($user->getId());

    #---------------------------------------------------------------------------------
    # Вид
    $view = @$_SESSION['view'] ? $_SESSION['view'] : 'line';
    $type = @$_SESSION['type'] ? $_SESSION['type'] : 'all';
    $onpage = @$_SESSION['onpage'] ? $_SESSION['onpage'] : '24';
    $new = @$_SESSION['new'] ? $_SESSION['new'] : 'all';

    # Сортировка
    $sort = @$_SESSION['sort'] ? $_SESSION['sort'] : 'id';
    $direction = @$_SESSION['direction'] == 'asc' ? 'asc' : 'desc';
    $page = @$_SESSION['page'] ? $_SESSION['page'] : '1';
    $data_sort = @explode("_", $sort);
    if (@$data_sort[0] == 's' && @$data_sort[1])
    {
      $param = $data_sort[1];
    }

    # Магазин
    $shops_query = ShopsQuery::create();
    $shops_query->join('Advs', Criteria::LEFT_JOIN);
    $shops_query->join('Regions', Criteria::LEFT_JOIN);
    if (@$_SESSION['region'] && $_SESSION['region'] != 'all')
    {
      $shops_query->where('Regions.Id = ?', $_SESSION['region']->getId());
    }
    $shops_query->filterByAlias($alias);
    $shop = $shops_query->findOne();
    
    if (!$shop) {
      throw new NotFoundHttpException('Пользователь отсутствует!');
      //return $this->redirect($this->generateUrl('site_shops_homepage'));
    }
    
    $category = new AdCategories();
    $category->setCatchPhrase('Доска объявлений MegaBob.ru');

    $advs = $shop->getAdvss();
    #####

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate($advs, $this->get('request')->query->get('page',
      1), $onpage);
      
    # Вы смотрели
    $yadvs = array();
    if (@$_SESSION['viewed_advs']) $yadvs = AdvsQuery::create()->filterById($_SESSION['viewed_advs'])->find();


    return $this->render('SiteFirstPageBundle:Default:shopadvs.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error,
      'csrf_token' => $csrfToken,
      'banner_top' => $banner_top,
      'banner_search' => $banner_search,
      'banner_advs' => $banner_advs,
      'banner_right' => $banner_right,
      'banner_bottom' => $banner_bottom,
      'top_panel' => $top_panel,
      'filt' => $filt,
      'view' => $view,
      'type' => $type,
      'onpage' => $onpage,
      'new' => $new,
      'sort' => $sort,
      'dir' => $direction,
      'page' => $page,
      'fields' => array(),
      'allfields' => array(),
      'search_form' => $search_form->createView(),
      'category' => $category,
      'advs' => $pagination,
      'shop' => @$shop ? : '',
      'user' => $user,
      'yadvs' => $yadvs,
      'menu' => $menu));
  }

  # -------------------------------------------------------
  # Добавление в избранное для авторизованных пользователей
  # -------------------------------------------------------

  public function add_to_favoriteAction($id, Request $request)
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $favorite = UserFavoriteQuery::create()->filterByFosUserId($user->getId())->filterByAdvId($id)->findOne();
	if (!$favorite) {
		$favorite = new UserFavorite();
		$favorite->setAdvId($id);
		$favorite->setFosUserId($user->getId());
		$favorite->save();
	}
    return $this->render('SiteFirstPageBundle:Default:empty.html.twig');
  }

  # -------------------------------------------------------
  # Удаление из избранного для авторизованных пользователей
  # -------------------------------------------------------

  public function del_favoriteAction($id, Request $request)
  {
    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();    
	$favorite = UserFavoriteQuery::create()->filterByFosUserId($user->getId())->filterByAdvId($id)->findOne();	
    if ($favorite) $favorite->delete();
    return $this->render('SiteFirstPageBundle:Default:empty.html.twig');
  }
  
  # ---------------------------------------------------------
  # Добавление в избранное для неавторизованных пользователей
  # ---------------------------------------------------------

  public function add_to_favorite_nAction($id, Request $request)
  {	
	if (@$_SESSION['favorite_advs']) {
		if (!in_array($id, $_SESSION['favorite_advs'])) {
			$_SESSION['favorite_advs'][$id]=$id;	
		}
	} else {
		$_SESSION['favorite_advs'] = array();
		$_SESSION['favorite_advs'][$id]=$id;
	}	
    return $this->render('SiteFirstPageBundle:Default:empty.html.twig');
  }

  # ---------------------------------------------------------
  # Удаление из избранного для неавторизованных пользователей
  # ---------------------------------------------------------

  public function del_favorite_nAction($id, Request $request)
  {
    if (@$_SESSION['favorite_advs']) {
		if (in_array($id, $_SESSION['favorite_advs'])) {
			unset($_SESSION['favorite_advs'][$id]);	
		}
	}	
    return $this->render('SiteFirstPageBundle:Default:empty.html.twig');
  }

  # ---------------------------
  # Подача жалобы на объявление
  # ---------------------------

  public function complainAction(Request $request)
  {
    $id = $request->get('adv');
    $reason = $request->get('reason');

    # ---- Данные пользователя ----
    $user = $this->container->get('security.context')->getToken()->getUser();

    $adv = AdvsQuery::create()->findOneById($id);

    if ($adv)
    {
      $complaine = new AdvComplaine();
      $complaine->setAdvId($id);
      $complaine->setFosUserId($user->getId());
      $complaine->setComplaine($reason);
      $complaine->save();
      $this->get('session')->getFlashBag()->add('noticesite',
        'Спасибо. Ваша жалоба № ' . $complaine->getId() .
        ' принята и будет расссмотрена в самое ближайшее время!');
    }

    return $this->redirect($referer = $request->headers->get('referer'));
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

  ##################################################
  #         Получение параметров GET-запроса       #
  ##################################################

  function getGetParamsAction(Request $request)
  {

    # Здесь мы получаем данные всех GET-запросов и сохраняем их в сессию
    # ------------------------------------------------------------------
    # GET-запросы
    $this->get('get_params')->build($request);

    return $this->render('SiteFirstPageBundle:Default:empty.html.twig');
  }

  ##################################################
  #         Выдача номера телефона по запросу      #
  ##################################################

  function getPhoneAction(Request $request)
  {

    $id = $request->request->get('id');
    $adv = AdvsQuery::create()->findOneById($id);
    if ($adv)
    {
      $phone = $this->format_phone($adv->getPhone());
      $adv->setCntTel($adv->getCntTel() + 1);
      $adv->setCntTelToday($adv->getCntTelToday() + 1);
      $adv->save();
    }

    return $this->render('SiteFirstPageBundle:Default:phone.html.twig', array('number' =>
        $phone));
  }
  
  ##################################################
  #              Выдача Skype по запросу           #
  ##################################################

  function getSkypeAction(Request $request)
  {

    $id = $request->request->get('id');
    $adv = AdvsQuery::create()->findOneById($id);
    if ($adv)
    {
      $skype = $adv->getSkype();
      $adv->setCntSkype($adv->getCntSkype() + 1);      
      $adv->save();
    }

    return $this->render('SiteFirstPageBundle:Default:phone.html.twig', array('number' =>
        $skype));
  }
  
  ##################################################
  #        Выдача адреса сайта по запросу          #
  ##################################################

  function getSiteAdvAction(Request $request)
  {

    $id = $request->request->get('id');
    $adv = AdvsQuery::create()->findOneById($id);
    if ($adv)
    {
      $site = $adv->getSite();
      $adv->setCntSite($adv->getCntSite() + 1);      
      $adv->save();
    }

    return $this->render('SiteFirstPageBundle:Default:phone.html.twig', array('number' =>
        $site));
  }

  ##################################################
  #         Запись клика по рекламному баннеру     #
  ##################################################

  function setClickAction(Request $request)
  {

    $id = $request->request->get('id');
    $banner = BannersQuery::create()->findOneById($id);
    if ($banner)
    {
      $banner->setClickToday($banner->getClickToday() + 1);
      $banner->save();
    }

    return $this->render('SiteFirstPageBundle:Default:empty.html.twig');
  }

  ##################################################
  #         Отправка сообщения пользователю        #
  ##################################################

  function sendMailAction(Request $request)
  {

	$top_panel = $this->get('toppanel')->buildPanel($request);
  $referer = $request->headers->get('referer');
	if (strpos($referer, mb_strtolower($top_panel['settings']->getName())) !== FALSE) {
		$recipient_id = $request->request->get('recipient_id');
		$adv_id = $request->request->get('adv_id');
		$sender_name = $request->request->get('sender_name');
		$sender_email = $request->request->get('sender_email');
		$sender_phone = @$request->request->get('sender_phone')?:NULL;
		$message_text = $request->request->get('message_text');

		$adv = AdvsQuery::create()->findOneById($adv_id);
		$user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' =>
			$recipient_id));
		if ($adv && $user)
		{
		  $subject = 'Новое сообщение на '.$top_panel['settings']->getName();
		  $from = $top_panel['settings']->getName().' <noreply@'.mb_strtolower($top_panel['settings']->getName()).'>';
		  $to = $user->getEmail();
		  $body = $this->renderView('SiteFirstPageBundle:Adv:send_mail.txt.twig', array(
			'top_panel' => $top_panel, 
      'email' => $user->getEmail(),
			'username' => $user->getRealname(),
			'sendername' => $sender_name,
			'senderemail' => $sender_email,
			'senderphone' => $sender_phone,
			'messagetext' => $message_text,
			'adv' => $adv));
		  if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) {
			$this->get('session')->getFlashBag()->add('noticesite', 'Спасибо, '.$sender_name.'. Ваше сообщение отправлено!');
			$new_message = new UserMessages();
			$new_message->setFosUserId($user->getId());
			$new_message->setSenderName($sender_name);
			$new_message->setSenderEmail($sender_email);
			$new_message->setSenderPhone($sender_phone);
			$new_message->setMessage($message_text.' - Объявление №'.$adv_id.' "'.$adv->getName().'"');
			$new_message->save();
			$user->setEmailSendCnt($user->getEmailSendCnt()+1);
			$user->save();
		  }
      /*
		  if ($user->getTelegram() && $user->getTelegramOn()) {
			$token = "366655492:AAH7rNtNASdn3ZegHL9M4zt9bs1pZ-5S8Gc";
			$bot = new \TelegramBot\Api\BotApi($token);
			$bot->sendMessage($user->getTelegram(), 'У Вас новое сообщение на Claso.ru от <b>'.$sender_name.'</b>: <i>'.$message_text.'</i> на объявление №'.$adv_id.' "'.$adv->getName().'". Подробности в вашем <a href="https://claso.ru/mymessages">Личном кабинете</a>','html');
		  }
      */
		}
	}

    return $this->redirect($referer);
  }

  ######################################################################
  #         Отправка сообщения пользователю от Администрации           #
  ######################################################################

  function sendMailAdminAction(Request $request)
  {

    $top_panel = $this->get('toppanel')->buildPanel($request);
    $referer = $request->headers->get('referer');
	if (strpos($referer, mb_strtolower($top_panel['settings']->getName())) !== FALSE) {
		$recipient_id = $request->request->get('recipient_id');
		$adv_id = @$request->request->get('adv_id') ? $request->request->get('adv_id') :
		  '';
		$admin = @$request->request->get('admin') ? $request->request->get('admin') : '';
		$sender_name = 'Администрация '.$top_panel['settings']->getName();
		$sender_email = 'admin@'.mb_strtolower($top_panel['settings']->getName());
		$message_text = $request->request->get('message_text');

		if ($adv_id) $adv = AdvsQuery::create()->findOneById($adv_id);
		$user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' =>
			$recipient_id));
		if ($user)
		{
		  $subject = 'Важное сообщение от Администрации '.$top_panel['settings']->getName();
		  $from = 'Администрация '.$top_panel['settings']->getName().' <admin@'.mb_strtolower($top_panel['settings']->getName()).'>';
		  $to = $user->getEmail();
		  $body = $this->renderView('SiteFirstPageBundle:Adv:send_mail_admin.txt.twig',
			array(
			'top_panel' => $top_panel, 
      'email' => $user->getEmail(),
			'username' => $user->getRealname(),
			'sendername' => $sender_name,
			'senderemail' => $sender_email,
			'messagetext' => $message_text,
			'adv' => @$adv ? $adv : ''));
		  if ($this->get('mail_helper')->sendMailing($from, $to, $subject, $body)) {
			if ($admin) {
			  $this->get('session')->getFlashBag()->add('notice1', 'Сообщение отправлено!');
			} else {
			  $this->get('session')->getFlashBag()->add('noticesite', 'Сообщение отправлено!');
			}  
			$new_message = new UserMessages();
			$new_message->setFosUserId($user->getId());
			$new_message->setSenderName($sender_name);
			$new_message->setSenderEmail($sender_email);
			$new_message->setMessage($message_text.($adv_id?' - Объявление №'.$adv_id.' "'.@$adv->getName().'"':''));
			$new_message->save();
			$user->setEmailSendCnt($user->getEmailSendCnt()+1);
			$user->save();
		  }
		  /*
		  if ($user->getTelegram() && $user->getTelegramOn()) {
			$token = "366655492:AAH7rNtNASdn3ZegHL9M4zt9bs1pZ-5S8Gc";
			$bot = new \TelegramBot\Api\BotApi($token);
			$bot->sendMessage($user->getTelegram(), 'У Вас новое сообщение на MegaBob.ru от <b>Администрации</b>: <i>'.$message_text.'</i>'.($adv_id?' на объявление №'.$adv_id.' "'.@$adv->getName().'"':''),'html');
		  }
			*/
		}
	}
    return $this->redirect($referer);
  }

  ######################################################################
  #                Очистка истории просмотра обявлений                 #
  ######################################################################

  function clearHistoryAction(Request $request)
  {

    $_SESSION['viewed_advs'] = array();

    return $this->redirect($referer = $request->headers->get('referer'));
  }

}

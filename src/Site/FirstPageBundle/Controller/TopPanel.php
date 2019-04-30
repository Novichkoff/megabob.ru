<?php

namespace Site\FirstPageBundle\Controller;

use \Criteria;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvComplaineQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\SettingsQuery;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopPanel
{
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function buildPanel(Request $request)
    {    
        
        # Определяем местоположение посетителя
        if (!@$_SESSION['geo_town']) {
          $geo = new GeoDetect;
          $town_detect = $geo->get_value('city',true);
          $geo_town = RegionsQuery::create()            
              ->filterByName($town_detect)            
              ->find();
          if (count($geo_town)) {
            # Если нашлось несколько городов с таким названием ищем еще и по региону
            if (count($geo_town)>1) {
              $region_detect = $geo->get_value('region');
              $f_r = explode(' ',$region_detect);
              $f_r = $f_r[0];
              $geo_area = AreasQuery::create()            
                ->filterByName('%'.$f_r.'%')          
                ->findOne();
              if (@$geo_area->getId())
                $geo_town = RegionsQuery::create()            
                  ->filterByAreaId($geo_area->getId())
                  ->filterByName($town_detect)            
                  ->findOne();				
              $_SESSION['geo_town'] = $geo_town;
            } else {
              $_SESSION['geo_town'] = $geo_town[0];
            }
          }		
        }
        
        # Если выбрали или сменили регион
        if ($request->attributes->get('region') != 'russia') {          
          $area = AreasQuery::create()->filterByAlias($request->attributes->get('region'))->findOne(); 
          $town_query = RegionsQuery::create();
          $town_query->filterByAlias($request->attributes->get('region'));
          $count = $town_query->count();
          if ( $count>1 && @$_SESSION['area'] ) $town_query->filterByAreaId($_SESSION['area']->getId());
          $town = $town_query->findOne();            
          if ($area) {
            $_SESSION['area'] = $area;
            $_SESSION['region']=NULL;
            $_SESSION['url_region'] = $request->attributes->get('region');
          } elseif ($town) {
            $_SESSION['region']=$town;
            $_SESSION['area'] = $town->getAreas(); 
            $_SESSION['url_region'] = $request->attributes->get('region');
          } else {
            $_SESSION['area']=NULL;
            $_SESSION['region']=NULL;
            $_SESSION['url_region'] = 'russia';
            //throw new NotFoundHttpException('Региона не существует');
          }       
        } else {
          $_SESSION['area']=NULL;
          $_SESSION['region']=NULL;
          $_SESSION['url_region'] = 'russia';
        }

        $settings = SettingsQuery::create()->findOne();        
		
        $regions = RegionsQuery::create()
            ->filterByDeleted(0)
            ->filterByType(array('1','2'))
            ->orderByType()
            ->orderByName()
            ->find();

        $areas = AreasQuery::create()
            ->join('Regions', Criteria::LEFT_JOIN)            
            ->filterByDeleted(0)
            ->groupById()
            ->orderByName()
            ->find();

        if (@$_SESSION['area']) $area_regions = RegionsQuery::create()
                ->filterByArray(array('deleted'=>0,'areaId'=>$_SESSION['area']->getId()))
                ->orderByType()->orderByName()
                ->find();                
        
        # Объявления для модератора
        
        $for_moders['advs'] = 0;	
		
        $for_moders['advs_num'] = NULL;

        # Жалобы для модератора
        
        $for_moders['complaines'] = NULL;
			
        # Магазины для модератора
        
        $for_moders['shops'] = NULL;           
        
        $main_categories = AdCategoriesQuery::create()
            ->join('AdChilds Childs', Criteria::LEFT_JOIN)
            ->orderBySort()
            ->orderBy('Childs.Sort')
            ->groupById()
            ->filterByDeleted(false)
            ->filterByParentId(NULL)
            ->find();
        
        $all_advs = array();
        $in = @$_SESSION['region']?$_SESSION['region']->getPageTitle():($_SESSION['area']?$_SESSION['area']->getPagetitle():'');
        $net = @$_SESSION['region']?$_SESSION['region']->getNet():($_SESSION['area']?$_SESSION['area']->getNet():'');

        return array(            
            'geo_town'			=> @$_SESSION['geo_town']?$_SESSION['geo_town']:0,
            'current_region'    => @$_SESSION['region']?:NULL,            
            'url_region'        => @$_SESSION['url_region']?:NULL,
            'current_area'      => @$_SESSION['area']?:NULL,
            'in_town'           => $in,
            'inn_town'          => @$_SESSION['region']?$_SESSION['region']->getName():($_SESSION['area']?$_SESSION['area']->getName():''),
            'net_town'          => $net,
            'regions'           => $regions,
            'area_regions'      => @$area_regions ? $area_regions : 0,
            'areas'             => $areas,
            'for_moders'        => $for_moders,
            'all_advs'          => $all_advs,
            'main_categories'  	=> $main_categories,
            'settings'          => $settings,
            'favorites'			    => @$_SESSION['favorite_advs']?:NULL
        );
    }   
	
} 
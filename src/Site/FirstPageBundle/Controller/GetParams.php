<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\RegionsQuery;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetParams
{

    ##################################################
    #         Получение параметров GET-запроса       #
    ##################################################

    public function build(Request $request)
    {
        
        // Если посетитель пришел из рассылки новых объявлений
        if (@$request->query->get('ref')) {
          $subscriber = AdCategoriesSubscribeQuery::create()->findOneByUnsubscribeCode($request->query->get('ref'));
          if ($subscriber) {
            $subscriber->setCnt($subscriber->getCnt()+1);
            $subscriber->save();
          }
        }
        # Здесь мы получаем данные всех GET-запросов и сохраняем их в сессию
        # ------------------------------------------------------------------

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
			  throw new NotFoundHttpException('Региона не существует');
            }       
          } else {
            $_SESSION['area']=NULL;
            $_SESSION['region']=NULL;
            $_SESSION['url_region'] = 'russia';
          }

        # Если выбрали или сменили режим просмотра объявлений
        if (@$request->get('view')) {
            $_SESSION['view'] = $request->get('view');
        }        
        if (@$request->get('type')) {
            $_SESSION['type'] = $request->get('type');
        }
        if (@$request->get('onpage')) {
            $_SESSION['onpage'] = $request->get('onpage');
        }
        if (@$request->get('new')) {
            $_SESSION['new'] = $request->get('new');
        }
        if (@$request->get('filt')) {
            $_SESSION['filt'] = $request->get('filt');
        }

        # Порядок сортировки таблиц
        if (@$request->get('sort')) {
          $sort = $request->get('sort');
          if ( $sort == 'photo') { $_SESSION['sort'] = 'AdvImages.Id'; }
          elseif ( $sort == 'city') { $_SESSION['sort'] = 'Regions.Name'; }
          elseif ( $sort == 'date') { $_SESSION['sort'] = 'publish_date'; }
          else { $_SESSION['sort'] = $request->get('sort'); }			
        }
        if (@$request->get('dir')) {
          $_SESSION['direction'] = $request->get('dir');
        }
        if (@$request->get('page')) {
          $_SESSION['page'] = $request->get('page');
        }

        return true;
    }
} 
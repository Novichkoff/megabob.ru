<?php

namespace Site\FirstPageBundle\Controller;
use Admin\AdminBundle\Model\AdvParamsPeer;
use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\UserAccountQuery;
use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\RegionsQuery;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Site\FirstPageBundle\Controller\TopPanel;
use Site\FirstPageBundle\Form\SimpleSearchType;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvsQuery;
use Site\FirstPageBundle\Form\Subscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\BannersQuery;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class SearchController extends Controller
{

    ##################################################
    #                 Страница поиска                #
    ##################################################

    public function indexAction($region, Request $request) {
        
        $_SESSION['start_time'] = microtime(true);
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

        $menu = MenuQuery::create()->find();
        
        # Данные пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user !='anon.') $user->account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());

        #---------------------------------------------------------------------------------

        # Получаем строку поиска
        $search_query = $request->query->all();

        $category = NULL;
        $fields = array();
        $allfields = array();
        $colors = array();

        # Поля категории списком
        $listing = array();
        $cfields = array();
        $sort_fields = array();
        
        $h1 = 'Результаты поиска';
        $page_title = 'Результаты поиска';
        $page_description = '';
        $page_text = '';
        
        # Категория
        if (@$search_query['cid']) {
            $category = AdCategoriesQuery::create()                
                ->filterById($search_query['cid'])                
                ->findOne();
                
            // SEO
            $h1 = $category->getName();
            $page_title = $this->seo($category->getPagetitle(),$top_panel);
            $page_description = $this->seo($category->getCatchPhrase(),$top_panel);
            $page_text = $this->seo($category->getText(),$top_panel);
            
            $category_array = array();
            $category_array[] = $category->getId();
            foreach ($category->getAdChildss() as $category_child) {
                $category_array[] = $category_child->getId();
            }            
             
            $category_fields = AdCategoriesFieldsQuery::create()
                ->filterByCategoryId(array($category->getParentId(), $category->getId()))
                ->findByArray(array(
                        'deleted' => false,
                        'enabled' => true,
                        'showInTable' => true
                    )
                );
            
            $all_fields = AdCategoriesFieldsQuery::create()
                ->filterByCategoryId(array($category->getParentId(), $category->getId()))
                ->orderBy('Name')
                ->findByArray(array(
                        'deleted' => false,
                        'enabled' => true
                    )
                );
			
			foreach( $all_fields as $all_field ) {
				$all_field_values = $all_field->getAdCategoriesFieldsValuess();
				foreach ($all_field_values as $all_field_value) {
					if ($all_field_value->getColor()) $colors[$all_field_value->getName()] = array('id'=>$all_field->getId(),'value'=>$all_field_value->getId(),'color'=>$all_field_value->getColor());
				}
                if ($all_field->getType() !=5) {
                    $allfields[$all_field->getId()] = array('id'=> $all_field->getId(),'name' => $all_field->getName(),'postfix' => $all_field->getPostfix());
                }
				$sort_fields[] = $all_field->getId();
            }

            # Поля категории
            foreach ($category_fields as $category_field) {
                $fields[$category_field->getId()] = $category_field;
				$cfields[]=$category_field->getId();
            }

            $category->childs = $category->getAdChildss();
            $category->parent = @$category->getAdCategoriesRelatedByParentId() ? $category->getAdCategoriesRelatedByParentId() : $category;
			
			# Поля категории списком
			$listing = array();

			foreach ($all_fields as $category_field) {
				if ($category_field->getListing()) {
					$listing_name = $category_field->getName();
					$listing_id = $category_field->getId();
					$listings = $category_field->getAdCategoriesFieldsValuess();
					$listing[$category_field->getId()]['id'] = $category_field->getId();
					foreach ($listings as $list) {
						$listing[$category_field->getId()]['values'][$list->getId()] = $list->getName();
					}
					if (is_array(@$listing[$category_field->getId()]['values']))
						asort($listing[$category_field->getId()]['values']);
				}
			}
            
        }
		
		if (@$search_query['area']) $_SESSION['find_area'] = $search_query['area'];
    if (@$region && $region !='russia') {
      $region_o = RegionsQuery::create()->findOneByAlias($region);
      if($region_o) $_SESSION['find_region'] = $region_o->getId();
    } elseif (@$search_query['region']) {
      $_SESSION['find_region'] = $search_query['region'];
    } else {
      $_SESSION['find_region'] = NULL;
    }
    

        $search_form = $this->createForm(new SimpleSearchType(), $category);
		
        #---- Баннеры --------
        $banner_search = $this->get('banner')->select($zone=2, $request, $category);
        $banner_bottom = $this->get('banner')->select($zone=5, $request, $category);
        $banner_right = $this->get('banner')->select($zone=4, $request, $category);        

        # Вид
        $view = @$_SESSION['view'] ? $_SESSION['view'] : 'line';
        $type = @$_SESSION['type'] ? $_SESSION['type'] : 'all';
        $onpage = @$_SESSION['onpage'] ? $_SESSION['onpage'] : '24';
        $new = @$_SESSION['new'] ? $_SESSION['new'] : '1000';
        $filt = @$_SESSION['filt'] ? $_SESSION['filt'] : 'hide';

        # Сортировка        
		$sort = @$_SESSION['sort'] ? $_SESSION['sort'] : 'UpDate';        
		$direction = @$_SESSION['direction'] =='asc' ? 'asc' : 'desc';
        $page = @$_SESSION['page'] ? $_SESSION['page'] : '1';
        $data_sort = @explode("_", $sort);        
		if ( @$data_sort[0] == 's' && @$data_sort[1] ) {
            if (in_array($data_sort[1],$sort_fields)) {
				$param = $data_sort[1];
			} else {
				$param = NULL;
				$sort = 'UpDate';
				$direction = 'desc';
			}
        }

        # Фильтр
        $price_array = array();
        $filter_array_id = array();
        $filter_array_value = array();
        $filter_array_between = array();
		$search_form->submit($request);        
        
		foreach ($search_form->all() as $item) {
            if ($item->getData()) {
                $item_name = $item->getName();
                $item_data = $item->getData();                
				if (gettype($item_data)=='double') $price_array[$item_name] = $item_data;
                if (gettype($item_data)=='integer') {
                    $var = @explode("_", $item_name);
                    if (@$var[1]) {                        
						if (@$listing[$var[1]]) {
                            $listing_val = $item_data;
                        }
                        $filter_array_id[$var[1]] = $item_data;
                    }
                }
                if (gettype($item_data)=='string') {
                    $var = @explode("_", $item_name);
                    $array = @explode("-", $item_data);                     
                    if (@$array[0] && @$array[1]) {                        
                        if (@$var[1]) {
                            $filter_array_between[$var[1]] = $array;
                        }
                    } elseif (@$array[0]!="" && @$array[1]!="") {
                        if (@$var[1]) {                            
							if (@$listing[$var[1]]) {
                                $listing_val = $item_data;
                            }
                            $filter_array_value[$var[1]] = $item_data;
                        }
                    }
                }
				if (gettype($item_data)=='array') {
					foreach ($item_data as $item_data_i) {
						if (gettype($item_data_i)=='integer') {
							$var = @explode("_", $item_name);
							if (@$var[1]) {
								$filter_array_id[$var[1]][] = $item_data_i;
							}
						}
						if (gettype($item_data_i)=='string') {
							$var = @explode("_", $item_name);
							$array = @explode("-", $item_data_i);                     
							if (@$array[0] && @$array[1]) {                        
								if (@$var[1]) {
									$filter_array_between[$var[1]][] = $array;
								}
							} elseif (@$array[0]!="" && @$array[1]!="") {
								if (@$var[1]) {
									$filter_array_value[$var[1]][] = $item_data_i;
								}
							}
						}
					}
				}
            }
        }
		
		$listing_value = NULL;
		if (@$listing_val) {
            $listing_value = AdCategoriesFieldsValuesQuery::create()->findOneById($listing_val);
        }

        ###################################################
        ##     Выборка объявлений (Большой запрос)       ##
        ###################################################

        $advs_query = AdvsQuery::create('Advs');        

        # Если выбрана категория
        if (@$search_query['cid']) {
            $advs_query->filterByCategoryId($category_array);
        }
        
        # Если выбрано "Искать в названии"
        if (@$search_query['sq']) { $advs_query->filterByText($search_query['sq']); }

        # Если выбран регион        
        if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {			
            $advs_query->where('Advs.RegionId = ?', $_SESSION['find_region']);
        }        
        if (@$search_query['area'] && $search_query['area'] != 'all') {
            $advs_query->where('Advs.AreaId = ?', $search_query['area']);
        }

        # Если выбрано "Только с фото"
        if (@$search_query['im']) {
            $advs_query->join('AdvImages');            
        } else {
            $advs_query->join('AdvImages',Criteria::LEFT_JOIN);
        }
        $advs_query->withColumn('AdvImages.Id', 'photo');
        $advs_query->withColumn('AdvImages.Thumb', 'thumb');
        $advs_query->groupBy('Id');        
        
        $advs_query->join('AdvParams Params', Criteria::LEFT_JOIN);
        # Фильтр
        if (@$price_array['sp_from']) $advs_query->where('Advs.Price > ?', $price_array['sp_from']);
        if (@$price_array['sp_to']) $advs_query->where('Advs.Price < ?', $price_array['sp_to']);
        $filterWhere = '';
        if ($filter_array_id) {            
          foreach ($filter_array_id as $key => $filter_array_id_item) {
            if (is_array($filter_array_id_item)) {
              foreach ($filter_array_id_item as $filter_array_id_iitem) {						
                $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.implode(',', $filter_array_id_item).'), 1, 0)) = 1';
              }					
            } else {					
              $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.$filter_array_id_item.'), 1, 0)) = 1';
            }                
          }
        }
        if ($filter_array_value) {
            foreach ($filter_array_value as $key => $filter_array_id_item) {
                $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue IN ('.implode(',', $filter_array_value).'), 1, 0)) = 1';
            }
        }		
        if ($filter_array_between) {
            foreach ($filter_array_between as $key => $filter_array_id_item) {                
				$filterWhere[] = '(MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1 OR MAX(IF(Params.FieldId = '.$key.' AND Values.Name between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1)';
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
		
        # Сортировка
        if (@$param) {
            $advs_query->where('Params.FieldId  = ?', $param);
            $advs_query->join('Params.AdCategoriesFieldsValues Values', Criteria::LEFT_JOIN);
            $advs_query->withColumn('Values.Name', $sort);
            $advs_query->withColumn('Params.TextValue', 'text_' . $sort);
        }
        $advs_query->orderBy($sort, $direction);
        if (@$param) {

            $column = 'text_' . $sort;

            if ($direction == 'asc') {
                $advs_query->addAscendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
            } else {
                $advs_query->addDescendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
            }
        }

        # Комментарии
        // $advs_query->join('AdvComments',Criteria::LEFT_JOIN);
        // $advs_query->orderBy('AdvComments.Date','asc');		     

        $advs_query->orderBy('AdvImages.Id','DESC');
        $advs_query->filterByArray(array(
            'enabled'       => true,
            'deleted'       => false
        ));		
		$advs_query->join('AdvPackets',Criteria::LEFT_JOIN);
		$advs_query->where('AdvPackets.PacketId = ?', 3);	
		
        ###################################################
      

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $advs_query,
            $this->get('request')->query->get('page', 1),
            $onpage
        );
		
		if (!$pagination->getTotalItemCount()) {
			$radvs_query = AdvsQuery::create('Advs');        

			# Если выбрана категория
			if (@$search_query['cid']) {
				$radvs_query->filterByCategoryId($category_array);
			}            

			# Если выбрано "Искать в названии"
			if (@$search_query['sq']) { $radvs_query->filterByText($search_query['sq']); }

			# Если выбран регион			
			if (@$search_query['area'] && $search_query['area'] != 'all') {
				$radvs_query->where('Advs.AreaId = ?', $search_query['area']);
			}

			# Если выбрано "Только с фото"
			if (@$search_query['im']) {
				$radvs_query->join('AdvImages');
			} else {
				$radvs_query->join('AdvImages',Criteria::LEFT_JOIN);
			}
			$radvs_query->withColumn('AdvImages.Id', 'photo');
      $radvs_query->withColumn('AdvImages.Thumb', 'thumb');
			$radvs_query->groupBy('Id');        
			
			$radvs_query->join('AdvParams Params', Criteria::LEFT_JOIN);
			# Фильтр
			if (@$price_array['sp_from']) $radvs_query->where('Advs.Price > ?', $price_array['sp_from']);
			if (@$price_array['sp_to']) $radvs_query->where('Advs.Price < ?', $price_array['sp_to']);
			$filterWhere = '';
			if ($filter_array_id) {            
				foreach ($filter_array_id as $key => $filter_array_id_item) {
					if (is_array($filter_array_id_item)) {
						foreach ($filter_array_id_item as $filter_array_id_iitem) {						
							$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.implode(',', $filter_array_id_item).'), 1, 0)) = 1';
						}					
					} else {					
						$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.$filter_array_id_item.'), 1, 0)) = 1';
					}                
				}
			}
			if ($filter_array_value) {
				foreach ($filter_array_value as $key => $filter_array_id_item) {
					$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue IN ('.implode(',', $filter_array_value).'), 1, 0)) = 1';
				}
			}		
			if ($filter_array_between) {
				foreach ($filter_array_between as $key => $filter_array_id_item) {                
					$filterWhere[] = '(MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1 OR MAX(IF(Params.FieldId = '.$key.' AND Values.Name between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1)';
				}
			}

			if ($filterWhere){
				$advs_where = AdvParamsQuery::create('Params')
					->join('Params.AdCategoriesFieldsValues Values',Criteria::LEFT_JOIN)
					->select('adv_id')
					->groupBy('adv_id')
					->having(implode(' AND ', $filterWhere))
					->find();

				$radvs_query->where('Advs.Id IN ?', $advs_where);
			}
			
			# Сортировка
			if (@$param) {
				$radvs_query->where('Params.FieldId  = ?', $param);
				$radvs_query->join('Params.AdCategoriesFieldsValues Values', Criteria::LEFT_JOIN);
				$radvs_query->withColumn('Values.Name', $sort);
				$radvs_query->withColumn('Params.TextValue', 'text_' . $sort);
			}
			$radvs_query->orderBy($sort, $direction);
			if (@$param) {

				$column = 'text_' . $sort;

				if ($direction == 'asc') {
					$radvs_query->addAscendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
				} else {
					$radvs_query->addDescendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
				}
			}

			$radvs_query->orderBy('AdvImages.Id','DESC');
			$radvs_query->filterByArray(array(
				'enabled'       => true,
				'deleted'       => false
			));		
			$radvs_query->join('AdvPackets',Criteria::LEFT_JOIN);
			$radvs_query->where('AdvPackets.PacketId = ?', 3);	
			
			###################################################
		  

			$paginator  = $this->get('knp_paginator');
			$r_pagination = $paginator->paginate(
				$radvs_query,
				$this->get('request')->query->get('page', 1),
				$onpage
			);
		}
		
		##############################
		
		$p_query = AdvsQuery::create('Advs');        

        # Если выбрана категория
        if (@$search_query['cid']) {
            $p_query->filterByCategoryId($category_array);
        }
		$p_query->join('AdvPackets',Criteria::LEFT_JOIN);
				
		$p_query->where('AdvPackets.Paid = ?', true);
		$p_query->where('AdvPackets.PacketId = ?', 1);
		$p_query->where('AdvPackets.UseBefore >= ?', strtotime( date("Y-m-d H:i:s") ) );

        # Если выбрано "Искать в названии"
        if (@$search_query['sq']) { $p_query->filterByText($search_query['sq']); }

        # Если выбран регион		
        if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {			
            $p_query->where('Advs.RegionId = ?', $_SESSION['find_region']);
        }
        
        if (@$search_query['area'] && $search_query['area'] != 'all') {
            $p_query->where('Advs.AreaId = ?', $search_query['area']);
        }

        # Если выбрано "Только с фото"
        if (@$search_query['im']) {
            $p_query->join('AdvImages');
        } else {
            $p_query->join('AdvImages',Criteria::LEFT_JOIN);
        }
		$p_query->withColumn('AdvImages.Id', 'photo');
    $p_query->withColumn('AdvImages.Thumb', 'thumb');
		$p_query->groupBy('Id');        
        
        $p_query->join('AdvParams Params', Criteria::LEFT_JOIN);
		# Фильтр
        if (@$price_array['sp_from']) $p_query->where('Advs.Price > ?', $price_array['sp_from']);
        if (@$price_array['sp_to']) $p_query->where('Advs.Price < ?', $price_array['sp_to']);
        $filterWhere = '';
        if ($filter_array_id) {
            foreach ($filter_array_id as $key => $filter_array_id_item) {
				if (is_array($filter_array_id_item)) {
					foreach ($filter_array_id_item as $filter_array_id_iitem) {
						$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.implode(',', $filter_array_id_item).'), 1, 0)) = 1';
					}					
				} else {
					$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.$filter_array_id_item.'), 1, 0)) = 1';
				}                
            }
        }
        if ($filter_array_value) {
            foreach ($filter_array_value as $key => $filter_array_id_item) {
                $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue IN ('.implode(',', $filter_array_value).'), 1, 0)) = 1';
            }
        }		
        if ($filter_array_between) {
            foreach ($filter_array_between as $key => $filter_array_id_item) {                
				$filterWhere[] = '(MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1 OR MAX(IF(Params.FieldId = '.$key.' AND Values.Name between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1)';
            }
        }

        if ($filterWhere){
            $p_where = AdvParamsQuery::create('Params')
				->join('Params.AdCategoriesFieldsValues Values',Criteria::LEFT_JOIN)
                ->select('adv_id')
                ->groupBy('adv_id')
                ->having(implode(' AND ', $filterWhere))
                ->find();

            $p_query->where('Advs.Id IN ?', $p_where);
        }
		
		# Сортировка
		if (@$param) {
            $p_query->where('Params.FieldId  = ?', $param);
            $p_query->join('Params.AdCategoriesFieldsValues Values', Criteria::LEFT_JOIN);
            $p_query->withColumn('Values.Name', $sort);
            $p_query->withColumn('Params.TextValue', 'text_' . $sort);
        }
        $p_query->orderBy($sort, $direction);
        if (@$param) {

            $column = 'text_' . $sort;

            if ($direction == 'asc') {
                $p_query->addAscendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
            } else {
                $p_query->addDescendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
            }
        }

        $p_query->orderBy('AdvImages.Id','DESC');
        $p_query->filterByArray(array(
            'enabled'       => true,
            'deleted'       => false
        ));		
		
		$premium_pagination = $paginator->paginate($p_query, $this->get('request')->query->get('page',1), 2);
		
		##############################
		
		$l_query = AdvsQuery::create('Advs');        

        # Если выбрана категория
        if (@$search_query['cid']) {
            $l_query->filterByCategoryId($category_array);
        }
		
		$l_query->join('AdvPackets',Criteria::LEFT_JOIN);
		
		$l_query->where('AdvPackets.Paid = ?', true);
		$l_query->where('AdvPackets.PacketId = ?', 2);
		$l_query->where('AdvPackets.UseBefore >= ?', strtotime( date("Y-m-d H:i:s") ) );

        # Если выбрано "Искать в названии"
        if (@$search_query['sq']) { $l_query->filterByText($search_query['sq']); }

        # Если выбран регион		
        if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {			
            $l_query->where('Advs.RegionId = ?', $_SESSION['find_region']);
        }      
        if (@$search_query['area'] && $search_query['area'] != 'all') {
            $l_query->where('Advs.AreaId = ?', $search_query['area']);
        }

        # Если выбрано "Только с фото"
        if (@$search_query['im']) {
            $l_query->join('AdvImages');
        } else {
            $l_query->join('AdvImages',Criteria::LEFT_JOIN);
        }
        $l_query->withColumn('AdvImages.Id', 'photo');
        $l_query->withColumn('AdvImages.Thumb', 'thumb');
        $l_query->groupBy('Id');        
        
        $l_query->join('AdvParams Params', Criteria::LEFT_JOIN);
		# Фильтр
        if (@$price_array['sp_from']) $l_query->where('Advs.Price > ?', $price_array['sp_from']);
        if (@$price_array['sp_to']) $l_query->where('Advs.Price < ?', $price_array['sp_to']);
        $filterWhere = '';
        if ($filter_array_id) {
            foreach ($filter_array_id as $key => $filter_array_id_item) {
				if (is_array($filter_array_id_item)) {
					foreach ($filter_array_id_item as $filter_array_id_iitem) {
						$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.implode(',', $filter_array_id_item).'), 1, 0)) = 1';
					}					
				} else {
					$filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.ValueId IN ('.$filter_array_id_item.'), 1, 0)) = 1';
				}                
            }
        }
        if ($filter_array_value) {
            foreach ($filter_array_value as $key => $filter_array_id_item) {
                $filterWhere[] = 'MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue IN ('.implode(',', $filter_array_value).'), 1, 0)) = 1';
            }
        }		
        if ($filter_array_between) {
            foreach ($filter_array_between as $key => $filter_array_id_item) {                
				$filterWhere[] = '(MAX(IF(Params.FieldId = '.$key.' AND Params.TextValue between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1 OR MAX(IF(Params.FieldId = '.$key.' AND Values.Name between '.$filter_array_id_item[0].' and '.$filter_array_id_item[1].', 1, 0)) = 1)';
            }
        }

        if ($filterWhere){
            $l_where = AdvParamsQuery::create('Params')
				->join('Params.AdCategoriesFieldsValues Values',Criteria::LEFT_JOIN)
                ->select('adv_id')
                ->groupBy('adv_id')
                ->having(implode(' AND ', $filterWhere))
                ->find();

            $l_query->where('Advs.Id IN ?', $l_where);
        }
		
		# Сортировка
		if (@$param) {
            $l_query->where('Params.FieldId  = ?', $param);
            $l_query->join('Params.AdCategoriesFieldsValues Values', Criteria::LEFT_JOIN);
            $l_query->withColumn('Values.Name', $sort);
            $l_query->withColumn('Params.TextValue', 'text_' . $sort);
        }
        $l_query->orderBy($sort, $direction);
        if (@$param) {

            $column = 'text_' . $sort;

            if ($direction == 'asc') {
                $l_query->addAscendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
            } else {
                $l_query->addDescendingOrderByColumn('CAST(' . $column . ' AS UNSIGNED)');
            }
        }
        
        $l_query->orderBy('AdvImages.Id','DESC');
        $l_query->filterByArray(array(
            'enabled'       => true,
            'deleted'       => false
        ));		
		
		$lite_pagination = $paginator->paginate($l_query, $this->get('request')->query->get('page',1), 2);

        # VIP объявления
        $vip_advs_query = AdvsQuery::create('Advs'); 
        
        # Если выбрана категория
        if (@$search_query['cid']) {
            $vip_advs_query->filterByCategoryId($search_query['cid']);
        }
        $vip_advs_query->join('Regions',Criteria::LEFT_JOIN);
        if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {			
            $vip_advs_query->where('Regions.Id = ?', $_SESSION['find_region']);
        }
		if (@$search_query['area'] && $search_query['area'] != 'all') {
            $vip_advs_query->where('Advs.AreaId = ?', $search_query['area']);
        }
        $vip_advs_query->join('AdvPackets',Criteria::LEFT_JOIN);
        $vip_advs_query->where('AdvPackets.PacketId = ?', 1);
        $vip_advs_query->where('AdvPackets.Paid = ?', 1);
        $vip_advs_query->where('AdvPackets.UseBefore >= ?', strtotime( date("Y-m-d H:i:s") ) );        
        $vip_advs = $vip_advs_query
          ->filterByArray(array(
            'enabled'       => true,
            'deleted'       => false
            ))          
          ->find();
		  
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
		  
	    # Вы смотрели
		$yadvs = array();
		if (@$_SESSION['viewed_advs'])
			foreach($_SESSION['viewed_advs'] as $yitem) {
				$yadvs[] = AdvsQuery::create()->findOneById($yitem);
			}
			
		# Подписка на новые объявления
		$subscribe = new AdCategoriesSubscribe();
		$cat_id = @$category?$category->getId():NULL;
		$subscribe->setCategoryId($cat_id);
    if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {			
            $subscribe->setTownId($_SESSION['find_region']);
		    $subscribe->setAreaId($search_query['area']);
        }		      
        if (@$search_query['area'] && $search_query['area'] != 'all') {
            $subscribe->setAreaId($search_query['area']);
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
						if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {						
							$subscribe_test_q->filterByTownId($_SESSION['find_region']);
							$subscribe_test_q->filterByAreaId($search_query['area']);						
						}        
						if (@$search_query['area'] && $search_query['area'] != 'all') {
							$subscribe_test_q->filterByAreaId($search_query['area']);
						}	
						$subscribe->setEmail($request->request->get('email'));
						$subscribe_test_q->filterByEmail($subscribe->getEmail());
						$subscribe_test = $subscribe_test_q->findOne();
					if (!$subscribe_test) {		
						# Фиксируем последнее объявление на текущий момент в данной рубрике
						$last_advs_query = AdvsQuery::create('Advs');
						if (@$search_query['cid']) $last_advs_query->filterByCategoryId($category_array);
						$last_advs_query->join('Regions', Criteria::LEFT_JOIN);
						$last_advs_query->join('Areas', Criteria::LEFT_JOIN);
						if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {			
						  $last_advs_query->where('Regions.Id = ?', $_SESSION['find_region']);
						} elseif (@$search_query['area'] && $search_query['area'] != 'all') {
						  $last_advs_query->where('Areas.Id = ?', $search_query['area']);
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
						$subscribe->setCategoryId($cat_id);					
						if (@$_SESSION['find_region'] && $_SESSION['find_region'] != 'all') {				
							$subscribe->setTownId($_SESSION['find_region']);
							$subscribe->setAreaId($search_query['area']);
						}        
						if (@$search_query['area'] && $search_query['area'] != 'all') {
							$subscribe->setAreaId($search_query['area']);
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
        
        $time = microtime(true) - @$_SESSION['start_time'];
        
		return $this->render('SiteFirstPageBundle:Search:index.html.twig',array(
            'title' => $page_title,
            'h1' => $h1,
            'description' => $page_description,
            'text' => $page_text,
            'last_username'     => $lastUsername,
            'error'             => $error,
            'csrf_token'        => $csrfToken,
            'banner_search'     => $banner_search,
            'banner_right'      => $banner_right,
            'banner_bottom'     => $banner_bottom,
            'view'              => $view,
            'type'              => $type,
            'category'          => $category,
            'onpage'            => $onpage,
            'new'               => $new,
            'dir'               => $direction,
            'filt'              => $filt,
            'fields'            => $fields,
            'top_panel'         => $top_panel,
            'search_form'       => $search_form->createView(),
            'subscribe_form' 	  => $subscribe_form->createView(),
            'subscribe_status'  => @$_SESSION['subscribe_form']?:'show',
            'advs'              => $pagination,
            'r_advs' 			      => @$r_pagination?:NULL,
            'p_advs' 			      => $premium_pagination,	
            'l_advs' 			      => $lite_pagination,				
            'allfields'         => $allfields,
            'vip_advs'          => $vip_advss,
            'yadvs' 			      => $yadvs,
            'listing'			      => $listing,
            'listing_value'     => $listing_value,
            'listing_name' 		  => @$listing_name?:'',
            'listing_id' 		    => @$listing_id?:'',
            'user'              => $user,
            'query'             => @$search_query['sq'] ? $search_query['sq'] : '',            
            'menu'              => $menu,
            'map_open'          => @$search_query['map_open'] ? 1 : 0,
            'colors'			      => $colors,
            'time'				      => $time
        ));
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
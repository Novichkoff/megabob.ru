<?php

namespace Admin\AdminBundle\Controller;

use Admin\AdminBundle\Form\AdCategoryFieldValuesType;
use Admin\AdminBundle\Form\AdCategoryFieldValuesListType;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesFields;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Admin\AdminBundle\Form\AdCategoriesType;
use Admin\AdminBundle\Form\AdCategoryFieldsType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class CategoriesController extends Controller
{

    # *********************
    # Категориии объявлений
    # *********************
    # --------------------------
    # Отображение всех категорий
    # --------------------------
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $categories = AdCategoriesQuery::create()->orderBySort()->find();

        if (!$categories) {
            throw $this->createNotFoundException(
                'Нет доступных категорий'
            );
        }

        foreach($categories as &$category){
            if ($category->getParentId()) $category->parent_name = AdCategoriesQuery::create()->findOneById( $category->getParentId() )->getName();
            else $category->parent_name = 'Корневая категория';
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories,
            $this->get('request')->query->get('page', 1),
            200
        );

        return $this->render('AdminAdminBundle:Categories:index.html.twig',array('pagination' => $pagination, 'for_moders' => $for_moders) );
    }
	
    # --------------------------
    #   Сортировка категорий
    # --------------------------
    public function sortAction(Request $request)
    {
        
		$array = $request->request->get('array');
		$cnt=1;
		foreach ($array as $item) {
			$category = AdCategoriesQuery::create()->findOneById($item);
			$category->setSort($cnt++);
			$category->save();
		}
        return new Response();
    }
    
    # -----------------------------
    #   Сортировка полей категорий
    # -----------------------------
    public function sortFieldsAction(Request $request)
    {
        
		$array = $request->request->get('array');
		$cnt=1;
		foreach ($array as $item) {
			$category = AdCategoriesFieldsQuery::create()->findOneById($item);
			$category->setSort($cnt++);
			$category->save();
		}
        return new Response();
    }
    
    # --------------------------------------
    #   Сортировка значений полей категорий
    # --------------------------------------
    public function sortValuesAction(Request $request)
    {
        
		$array = $request->request->get('array');
		$cnt=1;
		foreach ($array as $item) {
			$category = AdCategoriesFieldsValuesQuery::create()->findOneById($item);
			$category->setSort($cnt++);
			$category->save();
		}
        return new Response();
    }

    # ------------------------
    # Редактирование категорий
    # ------------------------
    public function editAction($id, Request $request)
    {

        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $category = AdCategoriesQuery::create()->findPk($id);

        if(!$category) {
            throw new NotFoundHttpException('Категория отсутствует!');
        }
        $icon = $category->getIcon();
        $category->setIcon('');
        if ( $category->getParentId() !=0 ) {
            $parentcategory_fields = AdCategoriesFieldsQuery::create()->orderById()->findByArray(array('categoryId' => $category->getParentId(), 'deleted' => 0));
        } else $parentcategory_fields = '';

        $category_fields = AdCategoriesFieldsQuery::create()->orderBySort()->findByArray(array('categoryId' => $id, 'deleted' => 0));

        $form = $this->createForm(new AdCategoriesType(),$category);

        $form->handleRequest($request);

        # Проверяем Алиас категории
        $alias_validation = AdCategoriesQuery::create()
            ->where('ad_categories.id != ?', $category->getId())
            ->findOneByArray( array( 'alias' => $category->getAlias(), 'deleted' => 0 ) );

        if (!$alias_validation) {

            if ($category->getParentId() == 0) { $category->setParentId(NULL); }
            
            if ($form->isValid()) {

                if ($form['icon']->getData()) {
                $dir = 'images/categories';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $category->setIcon($Filename);

                    $image = new Image($dir.'/'.$Filename);
                    //$image->fit_to_width(100);
                    $image->save($dir.'/'.$Filename);

                    if ($icon) {
                        $fs = new Filesystem();
                        try {
                            $fs->remove( $dir.'/'.$icon );
                        } catch (IOExceptionInterface $e) {
                            echo "Ошибка удаления изображения ".$e->getPath();
                        }
                    }
                }

                } else {
                    $category->setIcon($icon);
                }

                $category->save();

                $this->get('session')->getFlashBag()->add(
                    'notice1',
                    'Категория "'.$category->getName().'" успешно изменена!'
                );
                return $this->redirect($this->generateUrl('admin_admin_categoriespage'));
            }

        } else {

            $this->get('session')->getFlashBag()->add(
                'error1',
                'Алиас "'.$category->getAlias().'" уже используется!'
            );

        }
		
		$generator = NULL;
		if ($category->getGenerator()) {
			$generator = $category->getGenerator();
			$text = preg_match_all("/{(\d+)}/ix", $generator, $out, PREG_PATTERN_ORDER);
			foreach ($out[1] as $value) {
				$new_value = $this->getValue($value);
				$pattern = "/{".$value."\}/ix";				
				$generator = preg_replace($pattern,$new_value,$generator);
			}			
		}
		$subscribers = AdCategoriesSubscribeQuery::create()
            ->filterByCategoryId($category->getId())
            ->find();

        return $this->render('AdminAdminBundle:Categories:edit.html.twig', array(
            'form'                      => $form->createView(),
            'icon'                      => $icon,
            'id'                        => $id,
            'category_fields'           => $category_fields,
            'parentcategory_fields'     => $parentcategory_fields,
			'generator'					=> $generator,
			'subscribers'				=>$subscribers,
            'for_moders'                => $for_moders
        ));
    }
	
	function getValue($id) {
		$id = intval($id);		
		$field = AdCategoriesFieldsQuery::create()->findOneById($id);
		$value = AdCategoriesFieldsValuesQuery::create()->findOneByFieldId($id);
		if ($value) {
			$data = $value->getName();
		} else {
			if ($field->getType()==3) {
				$data = '123';
			} else {
				$data = 'абвгд';
			}
		}		
		return $data;
	}

    # --------------------
    # Добавление категорий
    # --------------------
    public function createAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $category = new AdCategories();

        $form = $this->createForm(new AdCategoriesType(), $category);

        $form->handleRequest($request);

        # Проверяем Алиас категории
        $alias_validation = AdCategoriesQuery::create()->findOneByArray(array('alias' => $category->getAlias(), 'deleted' => 0));

        if (!$alias_validation) {

            if ($form->isValid()) {

                if ($category->getParentId() == 0) { $category->setParentId(NULL); }

                if ($form['icon']->getData()) {
                    $dir = 'images/categories';
                    $file_type = $form['icon']->getData()->getMimeType();
                    switch($file_type) {
                        case 'image/png': $Filename = uniqid().'.png'; break;
                        case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                        case 'image/gif': $Filename = uniqid().'.gif'; break;
                    }

                    if ($Filename) {
                        $form['icon']->getData()->move($dir, $Filename);
                        $category->setIcon($Filename);

                        $image = new Image($dir.'/'.$Filename);
                        $image->fit_to_width(100);
                        $image->save($dir.'/'.$Filename);
                    }

                }

                $category->save();

                $this->get('session')->getFlashBag()->add(
                    'notice1',
                    'Категория "'.$category->getName().'" успешно добавлена!'
                );
                return $this->redirect($this->generateUrl('admin_admin_categoriespage'));
            }

        } elseif ( $category->getAlias() ) {

            $this->get('session')->getFlashBag()->add(
                'error1',
                'Алиас "'.$category->getAlias().'" уже используется!'
            );

        }

        return $this->render('AdminAdminBundle:Categories:add.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    # ------------------
    # Удаление категорий
    # ------------------
    public function deleteAction($id)
    {
        $category = AdCategoriesQuery::create()->findOneById($id);
        if(!$category) {
            throw new NotFoundHttpException('Категория отсутствует!');
        }

        $dir = 'images/categories';
        $Filename = $category->getIcon();
        if ($Filename) {
            $fs = new Filesystem();
            try {
                $fs->remove( $dir.'/'.$Filename );
            } catch (IOExceptionInterface $e) {
                echo "Ошибка удаления изображения ".$e->getPath();
            }
        }

        $category->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Категория "'.$category->getName().'" успешно удалена!'
        );

        $categories = AdCategoriesQuery::create()
            ->filterByParentId($id)
            ->find();
        foreach ($categories as $category_item) {
            $category_item->delete();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Подкатегория "'.$category_item->getName().'" успешно удалена!'
            );
        }

        return $this->redirect($this->generateUrl('admin_admin_categoriespage'));
    }

    # **************
    # Поля категорий
    # **************
    # --------------------------
    # Добавление полей категорий
    # --------------------------
    public function createFieldAction($category_id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $categoryfield = new AdCategoriesFields();
        $categoryfield->setCategoryId($category_id);

        $form = $this->createForm(new AdCategoryFieldsType(), $categoryfield);

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($categoryfield->getParentFieldId() == 0) $categoryfield->setParentFieldId(NULL);
            $categoryfield->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Поле "'.$categoryfield->getName().'" успешно добавлено!'
            );
            return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $categoryfield->getId())));
        }

        return $this->render('AdminAdminBundle:Categories:addfield.html.twig', array(
            'form'              => $form->createView(),
            'id'                => $category_id,
            'for_moders'        => $for_moders
        ));
    }

    # ------------------------------
    # Редактирование полей категорий
    # ------------------------------
    public function editFieldAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $categoryfield = AdCategoriesFieldsQuery::create()->findPk($id);
        $category_id = $categoryfield->getCategoryId();

        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }

        $form = $this->createForm(new AdCategoryFieldsType(), $categoryfield);

        $form->handleRequest($request);

        $type_field = $categoryfield->getType();

        $fieldvalues = ($type_field == 2 || $type_field == 6 || $type_field == 7 || $type_field == 8) ? AdCategoriesFieldsValuesQuery::create()->orderBySort()->findByArray(array('fieldId' => $id, 'deleted' => 0)) : '';

        if ($fieldvalues) {
            foreach ($fieldvalues as &$fieldvalue) {
                $fieldvalue->parentValueName = AdCategoriesFieldsValuesQuery::create()->findOneById($fieldvalue->getParentValueId()) ? AdCategoriesFieldsValuesQuery::create()->findOneById($fieldvalue->getParentValueId())->getName() : '';
            }
        }

        if ($form->isValid()) {

            if ($categoryfield->getParentFieldId() == 0) $categoryfield->setParentFieldId(NULL);
            $categoryfield->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Поле "'.$categoryfield->getName().'" успешно обновлено!'
            );
            //return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));
        }

        return $this->render('AdminAdminBundle:Categories:editfield.html.twig', array(
            'form'              => $form->createView(),
            'category_id'       => $category_id,
            'id'                => $id,
            'type_field'        => $type_field,
            'fieldvalues'       => $fieldvalues,
            'for_moders'        => $for_moders
        ));
    }

    # ------------------------------------
    # Удаление полей категорий
    # ------------------------------------
    public function deleteFieldAction($id)
    {

        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setDeleted(true);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" успешно удалено!'
        );

        # Удаление связанных значений полей
        $fieldvalues = AdCategoriesFieldsValuesQuery::create()->findByFieldId($id);
        if($fieldvalues) {
            foreach ($fieldvalues as $fieldvalue) {
                $fieldvalue->setDeleted(true);
                $fieldvalue->save();
                $this->get('session')->getFlashBag()->add(
                    'notice1',
                    'Значение "'.$fieldvalue->getName().'" успешно удалено!'
                );
            }
        }

        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));

    }

    # ------------------------------------
    # Включение/выключение полей категорий
    # ------------------------------------
    public function onFieldAction($id)
    {
        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setEnabled(true);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" включено!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));

    }

    public function offFieldAction($id)
    {
        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setEnabled(false);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" выключено!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));
    }

    # ------------------------------------------------
    # Отображение/отключение в фильтре полей категорий
    # ------------------------------------------------
    public function showFieldAction($id)
    {
        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setShowInFilter(true);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" добавлено в фильтр!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));

    }

    public function noshowFieldAction($id)
    {
        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setShowInFilter(false);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" удалено из фильтра!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));

    }
    
    # ------------------------------------------------
    # Отображение/отключение в таблице полей категорий
    # ------------------------------------------------
    public function showTableFieldAction($id)
    {
        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setShowInTable(true);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" добавлено в таблицу!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));

    }

    public function noshowTableFieldAction($id)
    {
        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $category_id = $categoryfield->getCategoryId();
        $categoryfield->setShowInTable(false);
        $categoryfield->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Поле "'.$categoryfield->getName().'" удалено из таблицы!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoriespage', array('id'=> $category_id)));

    }

    # ************************
    # Значения полей категорий
    # ************************
    # -----------------------------------
    # Добавление значений полей категорий
    # -----------------------------------
    public function createFieldValueAction($id, Request $request)
    {

        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $parent_field_id = $categoryfield->getParentFieldId();

        $fieldvalue = new AdCategoriesFieldsValues();
        $fieldvalue->setFieldId($id);
        $fieldvalue->setParentFieldId($parent_field_id);
        $fieldvalue->field_type = $categoryfield->getType();
        $fieldvalue->parent_field_name = AdCategoriesFieldsQuery::create()->findOneById($fieldvalue->getParentFieldId()) ? AdCategoriesFieldsQuery::create()->findOneById($fieldvalue->getParentFieldId())->getName() : '';

        $form = $this->createForm(new AdCategoryFieldValuesType(), $fieldvalue);

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/categories/values';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $fieldvalue->setIcon($Filename);

                    $image = new Image($dir.'/'.$Filename);
                    $image->best_fit(30,15);
                    $image->save($dir.'/'.$Filename);
                }

            }
            if (!$fieldvalue->getTitle()) $fieldvalue->setTitle($fieldvalue->getName());
            if (!$fieldvalue->getAlias()) $fieldvalue->setAlias($this->str2url($fieldvalue->getName()));

            $fieldvalue->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Значение "'.$fieldvalue->getName().'" успешно добавлено!'
            );
            return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $id)));
        }

        return $this->render('AdminAdminBundle:Categories:addvalue.html.twig', array(
            'form'              => $form->createView(),
            'id'                => $id,
            'for_moders'        => $for_moders
        ));
    }

    # ----------------------------------------------
    # Добавление нескольких значений полей категорий
    # ----------------------------------------------
    public function createFieldValuesAction($id, Request $request)
    {

        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $categoryfield = AdCategoriesFieldsQuery::create()->findOneById($id);
        if(!$categoryfield) {
            throw new NotFoundHttpException('Поле отсутствует!');
        }
        $parent_field_id = $categoryfield->getParentFieldId();

        $fieldvalues = new AdCategoriesFieldsValues();
        $fieldvalues->setFieldId($id);
        $fieldvalues->setParentFieldId($parent_field_id);
        $fieldvalues->field_type = $categoryfield->getType();
        $fieldvalues->parent_field_name = AdCategoriesFieldsQuery::create()->findOneById($fieldvalues->getParentFieldId()) ? AdCategoriesFieldsQuery::create()->findOneById($fieldvalues->getParentFieldId())->getName() : '';

        $form = $this->createForm(new AdCategoryFieldValuesListType(), $fieldvalues);

        $form->handleRequest($request);

        if ($form->isValid()) {

            if (@$fieldvalues->getName()) {
                $cnt=0;
                $names = explode(';',$fieldvalues->getName());
                foreach ($names as $name) {
                    $fieldvalue = new AdCategoriesFieldsValues();
                    $fieldvalue->setFieldId($id);
                    $fieldvalue->setParentFieldId($fieldvalues->getParentFieldId());
                    $fieldvalue->setParentValueId($fieldvalues->getParentValueId());
                    $fieldvalue->setName($name);
                    $fieldvalue->setTitle($name);
                    $fieldvalue->setAlias($this->str2url($name));
                    $fieldvalue->setTownId($fieldvalues->getTownId());
                    $fieldvalue->setEnabled($fieldvalues->getEnabled());
                    $fieldvalue->save();
                    $cnt++;
                }
            }

            $this->get('session')->getFlashBag()->add(
                'notice1',
                $cnt.' значений успешно добавлены!'
            );
            return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $id)));
        }

        return $this->render('AdminAdminBundle:Categories:addvalue.html.twig', array(
            'form'              => $form->createView(),
            'id'                => $id,
            'for_moders'        => $for_moders
        ));
    }

    # ---------------------------------------
    # Редактирование значений полей категорий
    # ---------------------------------------
    public function editFieldValueAction($id, Request $request)
    {

        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $fieldvalue = AdCategoriesFieldsValuesQuery::create()->findOneById($id);
        if(!$fieldvalue) {
            throw new NotFoundHttpException('Значение отсутствует!');
        }

        $icon = $fieldvalue->getIcon();
        $fieldvalue->setIcon('');

        $value_id = $fieldvalue->getFieldId();

        $fieldvalue->parent_field = AdCategoriesFieldsQuery::create()->findOneById($fieldvalue->getFieldId());
        $fieldvalue->parent_field_name = $fieldvalue->parent_field->getName();
        $fieldvalue->field_type = $fieldvalue->parent_field->getType();

        $form = $this->createForm(new AdCategoryFieldValuesType(), $fieldvalue);

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/categories/values';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $fieldvalue->setIcon($Filename);

                    $image = new Image($dir.'/'.$Filename);
                    $image->best_fit(30,15);
                    $image->save($dir.'/'.$Filename);

                    if ($icon) {
                        $fs = new Filesystem();
                        try {
                            $fs->remove( $dir.'/'.$icon );
                        } catch (IOExceptionInterface $e) {
                            echo "Ошибка удаления изображения ".$e->getPath();
                        }
                    }
                }

            } else {
                $fieldvalue->setIcon($icon);
            }

            $fieldvalue->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Значение "'.$fieldvalue->getName().'" успешно изменено!'
            );
            return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $value_id)));
        }

        return $this->render('AdminAdminBundle:Categories:editvalue.html.twig', array(
            'form'              => $form->createView(),
            'id'                => $value_id,
            'for_moders'        => $for_moders,
            'icon'              => $icon
        ));
    }

    # ---------------------------------------------
    # Включение/выключение значений полей категорий
    # ---------------------------------------------
    public function onFieldValueAction($id)
    {
        $fieldvalue = AdCategoriesFieldsValuesQuery::create()->findOneById($id);
        if(!$fieldvalue) {
            throw new NotFoundHttpException('Значение отсутствует!');
        }
        $value_id = $fieldvalue->getFieldId();

        $fieldvalue->setEnabled(true);
        $fieldvalue->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Значение "'.$fieldvalue->getName().'" включено!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $value_id)));

    }

    public function offFieldValueAction($id)
    {
        $fieldvalue = AdCategoriesFieldsValuesQuery::create()->findOneById($id);
        if(!$fieldvalue) {
            throw new NotFoundHttpException('Значение отсутствует!');
        }
        $value_id = $fieldvalue->getFieldId();

        $fieldvalue->setEnabled(false);
        $fieldvalue->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Значение "'.$fieldvalue->getName().'" выключено!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $value_id)));

    }

    # ---------------------------------
    # Удаление значений полей категорий
    # ---------------------------------
    public function deleteFieldValueAction($id)
    {
        $fieldvalue = $fieldvalue_old = AdCategoriesFieldsValuesQuery::create()->findOneById($id);
        if(!$fieldvalue) {
            throw new NotFoundHttpException('Значение отсутствует!');
        }
        $value_id = $fieldvalue->getFieldId();

        $dir = 'images/categories/values';
        $Filename = $fieldvalue->getIcon();
        if ($Filename) {
            $fs = new Filesystem();
            try {
                $fs->remove( $dir.'/'.$Filename );
            } catch (IOExceptionInterface $e) {
                echo "Ошибка удаления изображения ".$e->getPath();
            }
        }

        $fieldvalue->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Значение "'.$fieldvalue_old->getName().'" успешно удалено!'
        );
        return $this->redirect($this->generateUrl('admin_admin_editcategoryfieldpage', array('id'=> $value_id)));

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
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '_', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

}
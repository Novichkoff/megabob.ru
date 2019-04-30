<?php

namespace Site\FirstPageBundle\Form;

use \Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class SimpleSearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    # Выбор Региона
		$areas = AreasQuery::create()->orderByName()->find()->toKeyValue('Id','Name');
		$areas_array = array('all'=>'Все регионы');
    $areas_array = $areas_array + $areas;

		$current_area = @$_SESSION['find_area']?:(@$_SESSION['area']?$_SESSION['area']->getId():(@$_SESSION['area_id']?$_SESSION['area_id']:'all'));
    unset($_SESSION['area_id']);
		
		$builder->add('area', 'choice', array(
		  'choices' => $areas_array,
		  'mapped'    => FALSE,		  
		  'attr' => array('class' => 'search_changeable form-control selectpicker hidden-xs', 'data-live-search' => true),
		  'data' => $current_area));

		
		$current_region = @$_SESSION['find_area']?:((@$_SESSION['region'] && $_SESSION['region'] != 'all') ? $_SESSION['region']->getId():(@$_SESSION['region_id']?$_SESSION['region_id']:'all'));
      unset($_SESSION['find_area']);
      unset($_SESSION['region_id']);
    $regions_query = RegionsQuery::create();
    if (@$current_area != 'all') $regions_query->filterByAreaId($current_area);
    $regions = $regions_query->orderByType()->orderByName()->find()->toKeyValue('Id','Name');
    $regions_array = array('all'=>'Все города');
		if (@$current_area != 'all') $regions_array = $regions_array + $regions;    
    
    $builder->add('region', 'choice', array(
    'choices' => $regions_array,			
    'mapped'    => FALSE,	
    'attr' => array('class' => 'search_changeable form-control selectpicker', 'data-live-search' => (count($regions_array)>10)?true:false),
    'data' => $current_region));
		
		$category = @$options['data'] ? $options['data'] : NULL;
        $_SESSION['search_category'] = $category?$category->getId():NULL;        

        # Выбор Категории объявления
        $categories = AdCategoriesQuery::create()
            ->joinWith('AdChilds Childs',Criteria::LEFT_JOIN)
            ->filterByParentId(NULL)
            ->orderBySort()
            ->findByDeleted(false);
        $categories_array = array();
        $categories_array[0]='Все рубрики';
        foreach ($categories as $ccategory) {
            $categories_array[$ccategory->getId()]= $ccategory->getName();
            foreach ($ccategory->getAdChildss() as $subcategory) {
                $categories_array[$subcategory->getId()]= '^ '.$subcategory->getName();
            }
        }

        $builder
                ->add('cid', 'choice', array(
                    'choices'   => $categories_array,
                    'label'     => 'Рубрика',
                    'mapped'    => FALSE,
                    'required'  => TRUE,
                    'data'      => @$category ? $category->getId() : NULL,
                    'attr'      => array('class' => 'category_select search_changeable form-control selectpicker')
                ));

        $builder
            ->add('sq', 'text', array(
                'label'     => 'Поиск',
                'required'  => FALSE,
                'mapped'    => FALSE,
                'attr'      => array(
                'class'			=> 'search form-control',
								'placeholder'   => 'Поиск по объявлениям',
                                'autocomplete'  => 'off',
                                'spellcheck'    => 'false'
                                )
            ))            
            ->add('im', 'checkbox', array(
                'label'     => 'Только с фото',
                'required'  => FALSE,
                'attr'		  => array('class' => 'checkbox'),
                'mapped'    => FALSE
            ));

        # Цена
        $builder
            ->add('sp_from', 'money', array(
                'label'     => @$category?($category->getPriceTitle()?:'Цена'):'Цена',
                'precision' => 0,
                'required'  => FALSE,
                'mapped'    => FALSE,
                'attr'      => array('placeholder' => 'от')
            ))
            ->add('sp_to', 'money', array(                
                'precision' => 0,
                'required'  => FALSE,
                'mapped'    => FALSE,
                'attr'      => array('placeholder' => 'до')
            ));        
        
        # Добавление полей
        if ($category) {
            $category_fields = AdCategoriesFieldsQuery::create()
                ->join('AdCategoriesFieldsValues Values', Criteria::LEFT_JOIN)
                ->join('ChildsFields ChildsFields',Criteria::LEFT_JOIN)
                ->filterByCategoryId(array(@$category->getParentId(), @$category->getId()))
                ->orderByType()
                ->groupById()
                ->findByArray(array(
                        'deleted'       =>  false,
                        'enabled'       =>  true,
                        'showInFilter'  =>  true
                    )
                );
        }

        if (@$category_fields) {
            foreach($category_fields as $category_field) {

                # Типы полей: 1-текст; 2-список; 6-список зависимый от города; 7-список зависимый от региона;
                if ($category_field->getType() == 7) {
                    if (@$_SESSION['area']) {
                        $area = $_SESSION['area'];
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'areaId'        => $area->getId(),
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('sp_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => $category_field->getName(),
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker', 'title' => $category_field->getName()),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE,
								'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                'mapped'        => FALSE
                            ));
                        unset($values,$choices);
                    } else {
                        $values = array();
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('sp_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => $category_field->getName(),
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker', 'title' => $category_field->getName()),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE,
								'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                'mapped'        => FALSE
                            ));
                        unset($values,$choices);
                    }
                } elseif ($category_field->getType() == 6) {
                    if (@$_SESSION['region']) {
                        $region = $_SESSION['region'];
                        $parent_field_id = 0;
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'townId'        => $region->getId(),
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('sp_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => $category_field->getName(),
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker', 'title' => $category_field->getName()),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE,
								'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                'mapped'        => FALSE
                            ));
                        unset($values,$choices);
                    } else {
                        $values = array();
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('sp_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => $category_field->getName(),
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker', 'title' => $category_field->getName()),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE,
								'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                'mapped'        => FALSE
                            ));
                        unset($values,$choices);
                    }
                } elseif ($category_field->getType() == 2) {
                    if ($category_field->getParentFieldId() != 0) {
                        $parent_field_id = 0;
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'parentValueId' => $parent_field_id,
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();                        
						$builder->add('sp_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => $category_field->getName(),
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker', 'title' => $category_field->getName()),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE,
								'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                'mapped'        => FALSE
                            ));
                        unset($values,$choices);
                    } else {
                        $choices = $category_field->getAdCategoriesFieldsValuess();
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();						
                        $builder->add('sp_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => $category_field->getName(),
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker', 'title' => $category_field->getName()),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE,
								'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                'mapped'        => FALSE
                            ));
                        unset($values,$choices);
                    }
                } elseif ($category_field->getType() == 3) {
                    $builder->add('sp_'.$category_field->getId(), 'search', array('attr' => array('class' => 'sp_'.$category_field->getId(), 'placeholder'=>$category_field->getName()), 'label'  => @$category_field->getFilterName() ? $category_field->getFilterName() : $category_field->getName(), 'required'  => FALSE, 'mapped' => FALSE));
                } elseif ($category_field->getType() == 8) {
                    $builder->add('sp_'.$category_field->getId(), 'search', array('attr' => array('class' => 'sp_'.$category_field->getId(), 'placeholder'=>$category_field->getName()), 'label'  => @$category_field->getFilterName() ? $category_field->getFilterName() : $category_field->getName(), 'required'  => FALSE, 'mapped' => FALSE));
                } elseif ($category_field->getType() == 1) {
                    $builder->add('sp_'.$category_field->getId(), 'text', array('label'  => $category_field->getName(), 'attr' => array('class' => 'form-control', 'placeholder'=>$category_field->getName()), 'required' => FALSE, 'mapped' => FALSE));
                }
            }
        }       

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){

            $form = $event->getForm();
            $data = $event->getData();

            if (@$data['cid']) {                
              $category = AdCategoriesQuery::create()
                    ->filterById($data['cid'])
                    ->findOne();
                $_SESSION['search_category'] = $data['cid'];
            }			

            if (@$category) {
                # Добавление полей данной категории (подкатегории)
                
                $category_fields = AdCategoriesFieldsQuery::create()
                ->join('AdCategoriesFieldsValues', Criteria::LEFT_JOIN)
                ->join('ChildsFields ChildsFields',Criteria::LEFT_JOIN)
                ->filterByCategoryId(array(@$category->getParentId(), @$category->getId()))
                ->orderByType()
                ->groupById()
                ->findByArray(array(
                        'deleted'       =>  false,
                        'enabled'       =>  true,
                        'showInFilter'  =>  true
                    )
                );				

                if ($category_fields) {
                    foreach($category_fields as $category_field) {

                        # Типы полей: 1-текст; 2-список;
                        if ($category_field->getType() == 2) {
                            if ($category_field->getParentFieldId() != 0) {
                                if (@$data['sp_'.$category_field->getParentFieldId()]) {
                                    $parent_field_id = $data['sp_'.$category_field->getParentFieldId()];
                                } else {
                                    $parent_field_id = 0;
                                }
                                $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                                    'fieldId'       => $category_field->getId(),
                                    'parentValueId' => $parent_field_id,
                                    'deleted'       => false
                                ));
                                $values = array();
                                foreach ($choices as $choice){
                                    $values[$choice->getId()] = $choice->getName();
                                }
                                asort($values);
                                $category_field_childs = @$category_field->getChildsFieldss();
                                $form->add('sp_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName(),
                                        'empty_value'   => $category_field->getName(),
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker'),
                                        'disabled'      => $values ? false : true,
                                        'required'      => FALSE,
										'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                        'mapped'        => FALSE
                                    ));
                            } else {
                                $choices = $category_field->getAdCategoriesFieldsValuess();
                                $values = array();
                                foreach ($choices as $choice){
                                    $values[$choice->getId()] = $choice->getName();
                                }
                                asort($values);
                                $category_field_childs = @$category_field->getChildsFieldss();
                                $form->add('sp_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName(),
                                        'empty_value'   => $category_field->getName(),
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs[0] ? 'search_changeable form-control selectpicker' : 'form-control selectpicker'),
                                        'disabled'      => $values ? false : true,
                                        'required'      => FALSE,
										'multiple'      => @$category_field_childs[0] ? FALSE : TRUE,
                                        'mapped'        => FALSE
                                    ));
                            }
                        } elseif ($category_field->getType() == 3) {
                            $form->add('sp_'.$category_field->getId(), 'search', array('attr' => array('class' => 'sp_'.$category_field->getId(), 'placeholder'=>$category_field->getName()), 'label'  => @$category_field->getFilterName() ? $category_field->getFilterName() : $category_field->getName(), 'required' => FALSE, 'mapped' => FALSE));
                        } elseif ($category_field->getType() == 1) {
                            $form->add('sp_'.$category_field->getId(), 'text', array('label'  => $category_field->getName(), 'attr' => array('class' => 'form-control', 'placeholder'=>$category_field->getName()), 'required' => FALSE, 'mapped' => FALSE));
                        }
                    }
                } 
            }

        });
        
        $builder->getForm();

    }

    public function getName()
    {

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
        ));
    }

}

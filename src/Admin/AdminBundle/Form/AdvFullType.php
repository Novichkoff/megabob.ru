<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\AdvParams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class AdvFullType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id', 'text', array('label'  => '№ объявления:', 'read_only' => TRUE))
            ->add('deleted', 'checkbox', array('label'  => 'В архиве:', 'required' => FALSE))
            ->add('moder_approved', 'checkbox', array('label'  => 'Одобрено модератором:', 'required' => FALSE))
			->add('digest', 'checkbox', array('label'  => 'В дайджест:', 'required' => FALSE))
			->add('yandex_partner', 'checkbox', array('label'  => 'Яндекс-партнер:', 'required' => FALSE))
            ->add('cnt', 'text', array('label'  => 'Количество просмотров:', 'read_only' => TRUE))
            ->add('create_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Дата создания:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('publish_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Дата публикации:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('publish_before_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Опубликовано до:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('user_id', 'text', array('label'  => 'ID пользователя:', 'read_only' => TRUE))
            ->add('user_name', 'text', array('label'  => 'Имя пользователя:', 'mapped' => FALSE, 'read_only' => TRUE, 'data' => $options['data']->getUser()->getRealname()))
            ->add('user_type', 'choice', array(
                'choices' => array(
                    '1' => 'Частное лицо',
                    '2' => 'Компания'
                ),
                'label'  => 'Тип пользователя:'
            ))
            ->add('company_name', 'text', array('label'  => 'Название компании:', 'required'  => FALSE));

        # Выбор Магазина
        if (@$options['data']->getUserId()) {
          $shops = ShopsQuery::create()->FilterByFosUserId($options['data']->getUserId())->find();
          if (@$shops) {
            $shops_array = array();            
            foreach ($shops as $shop) {
                $shops_array[$shop->getId()]= $shop->getName();
            }
            $builder
            ->add('shop_id', 'choice', array(
                'choices'   => $shops_array,
                'label'  => 'Компания:',
                'attr'  => array('class' => 'form-control'),
                'help'  => 'Вы можете выбрать одну из своих компаний.',
                'required'  => FALSE
            ));
          }
        }

        $builder
            ->add('user_email', 'text', array('label'  => 'Email пользователя:', 'mapped' => FALSE, 'read_only' => TRUE, 'data' => $options['data']->getUser()->getEmail()))
            ->add('name', 'text', array('label'  => 'Заголовок объявления:'))
            ->add('phone', 'text', array('label'  => 'Контактный телефон:'))
			->add('skype', 'text', array('label' => 'Skype:','required' => false))
			->add('youtube', 'text', array('label' => 'Видео:','required' => false));

        # Выбор Категории объявления
        $categories = AdCategoriesQuery::create()
            ->filterByParentId(NULL)
            ->orderByParentId()
            ->findByDeleted(0);
        $categories_array = array();
        foreach ($categories as $category) {
            $categories_array[$category->getName()]= array();
            $subcategories = AdCategoriesQuery::create()->filterByParentId($category->getId())->orderByName()->find();
            foreach ($subcategories as $subcategory) {
                $categories_array[$category->getName()][$subcategory->getId()]= $subcategory->getName();
            }
        }
        $builder
            ->add('category_id', 'choice', array(
                'choices'   => $categories_array,
                'label'  => 'Категория:',
                'attr' => array('class' => 'category_select')
            ));

        # Дополнительные поля Категории
        $category = AdCategoriesQuery::create()->findOneById($options['data']->getCategoryId());


        $category_fields = AdCategoriesFieldsQuery::create()
            ->filterByCategoryId(array($category->getParentId(), $category->getId()))
            ->findByArray(array(
                'deleted' => 0,
                'enabled' => 1
                )
            );

        if (@$category_fields) {
            foreach($category_fields as $category_field) {

                # Типы полей: 1-текст; 2-список; 6-список зависимый от города; 7-список зависимый от региона;
                if ($category_field->getType() == 7) {
                    if (@$options['data']->getAreaId()) {
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'areaId'        => $options['data']->getAreaId(),
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable' : ''),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE
                            ));
                        unset($values,$choices);
                    } else {
                        $values = array();
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable' : ''),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE
                            ));
                        unset($values,$choices);
                    }
                } elseif ($category_field->getType() == 6) {
                    if (@$options['data']->getRegionId()) {
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'townId'        => $options['data']->getRegionId(),
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable' : ''),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE
                            ));
                        unset($values,$choices);
                    } else {
                        $values = array();
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable' : ''),
                                'disabled'      => $values ? false : true,
                                'required'      => FALSE
                            ));
                        unset($values,$choices);
                    }
                }
				elseif ($category_field->getType() == 9)
					{
					  $builder->add('params_' . $category_field->getId(), 'checkbox',
						  array(
						  'label' => $category_field->getName(),						  
						  'data' => $options['data']->{'params_'.$category_field->getId()}?true:false,
						  'required' => false)); 	  
					}
				elseif ($category_field->getType() == 2 || $category_field->getType() == 8) {
                    if ($category_field->getParentFieldId() != 0) {
                        if (@$options['data']->{'params_'.$category_field->getParentFieldId()}) {
                            $parent_field_id = @$options['data']->{'params_'.$category_field->getParentFieldId()};
                        } else {
                            $parent_field_id = 0;
                        }
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId' => $category_field->getId(),
                            'parentValueId' => $parent_field_id,
                            'deleted' => 0
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName(),
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'required'      => FALSE
                            ));
                    } else {
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId' => $category_field->getId(),
                            'deleted' => 0
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'  => $category_field->getName(),
                                'choices'   => $values,
                                'required' => FALSE
                            ));
                    }
                } else {
                    $builder->add('params_'.$category_field->getId(), 'text', array('label'  => $category_field->getName(), 'required' => FALSE));
                }
            }
        }

        # Выбор Региона
        $areas = AreasQuery::create()->orderByName()->find();
        $areas_array = array();
        foreach ($areas as $area) {
            $areas_array[$area->getId()] = $area->getName();
        }

        $builder
            ->add('area_id', 'choice', array(
                'choices'   => $areas_array,
                'label'     => 'Регион'
            ));

        # Выбор Города
        $regions_query = RegionsQuery::create();
        if (@$options['data']->getAreaId()) $regions_query->filterByAreaId($options['data']->getAreaId());
        $regions = $regions_query->orderByName()->find();
        $regions_array = array();
        foreach ($regions as $region) {
            $regions_array[$region->getId()] = $region->getName();
        }

        $builder
            ->add('region_id', 'choice', array(
                'choices'   => $regions_array,
                'label'     => 'Город'
            ));

        $builder            
            ->add('description', 'textarea', array('label'  => 'Описание:'))
            ->add('price', 'text', array('label'  => 'Цена:'))
            ->add('coord', 'text', array('label'  => 'Координаты:', 'required' => FALSE))
            ->add('dogovor', 'checkbox', array('label'  => 'Договорная цена:', 'required' => FALSE))
            ->add('torg', 'checkbox', array('label'  => 'Торг:', 'required' => FALSE))
            ->add('enabled', 'checkbox', array('label'  => 'Включено:', 'required' => FALSE))
			->add('site', 'text', array('label' => 'Сайт:','required' => false));

        # Кнопка Сохранить расположена в шаблоне Advs\edit.html.twig

        $builder
            ->getForm();

    }

    public function getName()
    {
        return 'advs';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Advs',
        ));*/
    }

}

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
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsValues;
use Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\JobParams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class ResumeFullType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id', 'text', array('label'  => '№ резюме:', 'read_only' => TRUE))
            ->add('moder_approved', 'checkbox', array('label'  => 'Одобрено модератором:', 'required' => FALSE))
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
            ->add('user_name', 'text', array('label'  => 'Логин пользователя:', 'mapped' => FALSE, 'read_only' => TRUE, 'data' => $options['data']->getUser()->getUsername()))
            ->add('user_email', 'text', array('label'  => 'Email пользователя:', 'mapped' => FALSE, 'read_only' => TRUE, 'data' => $options['data']->getUser()->getEmail()))
            ->add('name', 'text', array('label'  => 'Фамилия Имя Отчество:'))
            ->add('phone', 'text', array('label'  => 'Контактный телефон:'));

        # Выбор Категории вакансии
        $categories = JobCategoriesQuery::create()
            ->filterByParentId(0)
            ->orderByParentId()
            ->findByDeleted(0);
        $categories_array = array();
        foreach ($categories as $category) {
            $categories_array[$category->getName()]= array();
            $subcategories = JobCategoriesQuery::create()->filterByParentId($category->getId())->orderByName()->find();
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
        $category = JobCategoriesQuery::create()->findOneById($options['data']->getCategoryId());


        $category_fields = JobCategoriesFieldsQuery::create()
            ->filterByCategoryId(array(0, $category->getParentId(), $category->getId()))
            ->findByArray(array(
                'deleted' => 0,
                'enabled' => 1
                )
            );

        if (@$category_fields) {
            foreach($category_fields as $category_field) {

                # Типы полей: 1-текст; 2-список;
                if ($category_field->getType() == 2) {
                    if ($category_field->getParentFieldId() != 0) {
                        if (@$options['data']->{'params_'.$category_field->getParentFieldId()}) {
                            $parent_field_id = @$options['data']->{'params_'.$category_field->getParentFieldId()};
                        } else {
                            $parent_field_id = 0;
                        }
                        $choices = JobCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId' => $category_field->getId(),
                            'parentValueId' => $parent_field_id,
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
                    } else {
                        $choices = JobCategoriesFieldsValuesQuery::create()->findByArray(array(
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
        $regions = RegionsQuery::create()->orderByName()->find();
        $regions_array = array();
        foreach ($regions as $region) {
            $regions_array[$region->getId()] = $region->getName();
        }

        $builder
            ->add('region_id', 'choice', array(
                'choices'   => $regions_array,
                'label'     => 'Регион'
            ));

        $builder
            ->add('description', 'textarea', array('label'  => 'Автобиография:'))
            ->add('price_from', 'text', array('label'  => 'Зарплата от:', 'help' => 'Укажите зарплату'))
            ->add('price_to', 'text', array('label'  => 'Зарплата до:', 'help' => 'Укажите зарплату'))
            ->add('enabled', 'checkbox', array('label'  => 'Включено:', 'required' => FALSE));

        # Кнопка Сохранить расположена в шаблоне Jobs\edit.html.twig

        $builder
            ->getForm();

    }

    public function getName()
    {
        return 'jobs';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Advs',
        ));*/
    }

}

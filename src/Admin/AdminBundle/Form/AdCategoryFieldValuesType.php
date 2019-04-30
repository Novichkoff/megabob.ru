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

use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdCategoryFieldValuesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if ($options['data']->field_type == 6) {
            $towns = RegionsQuery::create()->orderByName()->filterByDeleted(false)->find();
            $town_array = array();
            foreach ($towns as $town) {
                $town_array[$town->getId()]= $town->getName();
            }
            $builder
                ->add('town_id', 'choice', array(
                    'choices'   => $town_array,
                    'label'  => 'Город'
                ));
        }
        if ($options['data']->field_type == 7) {
            $areas = AreasQuery::create()->orderByName()->filterByDeleted(false)->find();
            $area_array = array();
            foreach ($areas as $area) {
                $area_array[$area->getId()]= $area->getName();
            }
            $builder
                ->add('area_id', 'choice', array(
                    'choices'   => $area_array,
                    'label'  => 'Регион'
                ));
        }
        
		if ($options['data']->getParentFieldId()) {
            $parent_values = AdCategoriesFieldsValuesQuery::create()->findByFieldId($options['data']->getParentFieldId());
            $parent_values_array = array();
            foreach ($parent_values as $parent_value) {
                $parent_values_array[$parent_value->getId()]= $parent_value->getName();
            }

            $builder
                ->add('parent_value_id', 'choice', array(
                    'choices'   => $parent_values_array,
                    'label'  => $options['data']->parent_field_name,
                ));
        }
            $builder
                ->add('name', 'text', array('label'  => 'Значение',))
                ->add('alias', 'text', array('label'  => 'Алиас', 'required' => false))
                ->add('title', 'text', array('label'  => 'Заголовок', 'required' => false))
                ->add('description', 'textarea', array('label'  => 'Текст', 'required' => false))
                ->add('enabled', 'checkbox', array('label'  => 'Включено', 'required' => false, 'data' => ($options['data']->getEnabled() == 1) ? true : false))
                ->add('color', 'text', array('label'  => 'Цвет для карты', 'required' => false, 'data' => $options['data']->getColor()))
                ->add('icon', 'file', array('label'  => 'Изображение для Значения', 'required' => false))
                ->add('save', 'submit', array('label'  => 'Сохранить',))
                ->getForm();

    }

    public function getName()
    {
        return 'adCategoriesFields';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\AdCategoriesFieldsValues',
        ));
    }

}
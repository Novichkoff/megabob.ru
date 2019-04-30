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

use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdCategoryFieldsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
		$categories = AdCategoriesQuery::create()->findByDeleted(0);
        $categories_array = array();
        foreach ($categories as $category) {
            $categories_array[$category->getId()]= ($category->getParentId()==0) ? $category->getName() : AdCategoriesQuery::create()->findOneById( $category->getParentId() )->getName().' -> '.$category->getName();
        }
		if (@$options['data']->getCategoryId()) $categorry = AdCategoriesQuery::create()->findOneById($options['data']->getCategoryId());

        $categoryfields = AdCategoriesFieldsQuery::create()->filterByCategoryId(array($categorry->getId(),$categorry->getParentId()))->findByDeleted(0);
        $categoryfields_array = array();
        $categoryfields_array[0] = 'Независимое поле';
        foreach ($categoryfields as $categoryfield) {
            if ($categoryfield->getParentFieldId()==0) $categoryfields_array[$categoryfield->getId()] = $categoryfield->getName();
            else $categoryfields_array[$categoryfield->getId()] = AdCategoriesFieldsQuery::create()->findOneById( $categoryfield->getParentFieldId() )->getName().' -> '.$categoryfield->getName();
        }
		$mask_array = array(
			"'mask': '9999'" => 'год',
			"'alias': 'numeric'" => 'число',
			"'mask': '9{1,2}/9{1,2}'" => '99/99',
			"'mask': '9{1,3}/9{1,3}/9{1,3}'" => '999/999/999'
		);

        $builder
            ->add('name', 'text', array('label'  => 'Название поля'))
            ->add('filter_name', 'text', array('label'  => 'Короткое название', 'required' => false))            
            ->add('category_id', 'choice', array(
                'choices'   => $categories_array,
                'label'  => 'Категория',
                'disabled' => true,
            ))
            ->add('parent_field_id', 'choice', array(
                'choices'   => $categoryfields_array,
                'label'  => 'Родительское поле',
            ))
            ->add('type', 'choice', array(
                'choices'   => array('1'=>'Текстовое поле', '2'=>'Список', '3'=>'Числовое поле', '4' => 'Адрес', '5' => 'Координаты', '6' => 'Список, зависимый от города', '7' => 'Список, зависимый от региона', '8'=>'Числовой список', '9'=>'Флажок'),
                'label'  => 'Тип поля',
            ))
            ->add('helper', 'text', array('label'  => 'Подпись к полю', 'required' => false))
            ->add('postfix', 'text', array('label'  => 'Постфикс', 'required' => false))
            ->add('mask', 'choice', array(
                      'choices'   => $mask_array,
                      'label'  => 'Маска поля',
              'required' => false
                  ))
            ->add('required', 'checkbox', array('label'  => 'Обязательное поле', 'required' => false, 'data' => ($options['data']->getRequired() == 1) ? true : false))
            ->add('show_in_filter', 'checkbox', array('label'  => 'Показывать в фильтре', 'required' => false, 'data' => ($options['data']->getShowInFilter() == 1) ? true : false))
            ->add('enabled', 'checkbox', array('label'  => 'Включено', 'required' => false, 'data' => ($options['data']->getEnabled() == 1) ? true : false))
            ->add('listing', 'checkbox', array('label'  => 'Списком под фильтром', 'required' => false, 'data' => ($options['data']->getListing() == 1) ? true : false))
            ->add('show_on_map', 'checkbox', array('label'  => 'Указывать на карте', 'required' => false, 'data' => ($options['data']->getShowOnMap() == 1) ? true : false))
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
            'data_class' => 'Admin\AdminBundle\Model\AdCategoriesFields',
        ));
    }

}

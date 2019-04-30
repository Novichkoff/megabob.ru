<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\AdCategoriesQuery;

class AdCategoriesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $categories = AdCategoriesQuery::create()->findByDeleted(0);
        $categories_array = array();        
        if ($categories) foreach ($categories as $category) {
            $categories_array[$category->getId()] = ($category->getParentId()== NULL) ? $category->getName() : AdCategoriesQuery::create()->findOneById( $category->getParentId() )->getName().' : '.$category->getName();
        }

        $builder
            ->add('name', 'text', array('label'  => 'Название категории',))
            ->add('parent_id', 'choice', array(
                'empty_value' => 'Корневая категория',
                'choices'     => $categories_array,
                'label'       => 'Родительская категория',
                'required'    => false
            ))
            ->add('alias', 'text', array('label'  => 'Алиас категории'))
            ->add('pagetitle', 'text', array('label'  => 'Текст для заголовка'))
			->add('generator', 'text', array('label'  => 'Генератор Названий', 'required' => false))
			->add('nametitle', 'text', array('label'  => 'Подпись к Названию', 'required' => false))
			->add('desctitle', 'text', array('label'  => 'Подпись к Описанию', 'required' => false))
			->add('pricetitle', 'text', array('label'  => 'Подпись к Цене', 'required' => false))
			->add('use_dogovor', 'checkbox', array('label'  => 'Договорная цена', 'required' => false))
			->add('use_torg', 'checkbox', array('label'  => 'Торг', 'required' => false))
            ->add('catch_phrase', 'text', array('label'  => 'Описание', 'required' => false))
			->add('text', 'textarea', array('label'  => 'Текст', 'required' => false))
			->add('direct_title', 'text', array('label'  => 'Подать объявление бесплатно ...', 'required' => false))
            ->add('icon', 'file', array('label'  => 'Изображение категории', 'required' => false))            
            ->add('onmain', 'checkbox', array('label'  => 'Отображать на Главной', 'required' => false))
            ->add('usemap', 'checkbox', array('label'  => 'Интерактивная карта', 'required' => false))
            ->add('save', 'submit', array('label'  => 'Сохранить',))
            ->getForm();

    }

    public function getName()
    {
        return 'adCategories';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\AdCategories',
        ));
    }

}

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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\CouponsCategoriesQuery;

class CouponsCategoriesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $categories = CouponsCategoriesQuery::create()->findByDeleted(0);
        $categories_array = array();
        $categories_array[0] = 'Корневая категория';
        if ($categories) foreach ($categories as $category) {
            $categories_array[$category->getId()]= ($category->getParentId()==0) ? $category->getName() : CouponsCategoriesQuery::create()->findOneById( $category->getParentId() )->getName().' -> '.$category->getName();
        }

        $builder
            ->add('name', 'text', array('label'  => 'Название категории',))
            ->add('parent_id', 'choice', array(
                'choices'   => $categories_array,
                'label'  => 'Родительская категория',
            ))
            ->add('alias', 'text', array('label'  => 'Алиас категории'))
            ->add('pagetitle', 'text', array('label'  => 'Текст для заголовка'))
            ->add('catch_phrase', 'text', array('label'  => 'Крылатая фраза', 'required' => false))            
            ->add('icon', 'file', array('label'  => 'Изображение категории', 'required' => false))
            ->add('onmain', 'checkbox', array('label'  => 'Отображать на Главной', 'required' => false))
            //->add('usemap', 'checkbox', array('label'  => 'Интерактивная карта', 'required' => false))
            ->add('save', 'submit', array('label'  => 'Сохранить',))
            ->getForm();

    }

    public function getName()
    {
        return 'couponsCategories';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\CouponsCategories',
        ));
    }

}

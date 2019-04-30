<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use Admin\AdminBundle\Model\AdCategoriesQuery;

class PacketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'  => 'Название пакета:', 'required' => TRUE, 'read_only' => TRUE))
            ->add('title', 'text', array('label'  => 'Заголовок пакета:', 'required' => TRUE))
            ->add('description', 'textarea', array('label'  => 'Описание:', 'required' => FALSE))
            ->add('price', 'text', array('label'  => 'Стоимость пакета:', 'required' => FALSE))
            ->add('sale', 'text', array('label'  => 'Размер скидки:', 'required' => FALSE))
            ->add('days', 'text', array('label'  => 'Продолжительность действия (дн.):', 'required' => FALSE))
            ->add('save', 'submit', array('label'  => 'Сохранить',))
            ->getForm();
    }

    public function getName()
    {
        return 'packets';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Packets'
        ));
    }

}


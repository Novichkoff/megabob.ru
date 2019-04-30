<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\RegionsQuery;

class ShopsFullType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('name', 'text', array('label'  => 'Название:', 'required' => TRUE))
      ->add('title', 'text', array('label'  => 'Заголовок:', 'required' => TRUE))
      ->add('alias', 'text', array('label'  => 'Алиас:', 'required' => TRUE));

    # Выбор Региона
    $regions = RegionsQuery::create()->orderByName()->find();
    $regions_array = array();
    $regions_array[]='';
    foreach ($regions as $region) {
      $regions_array[$region->getId()]= $region->getName();
    }

    $builder
      ->add('region_id', 'choice', array(
        'choices'   => $regions_array,
        'label'     => 'Город:',
        'attr'      => array('class' => 'form-control'),
        'required' => true
    ));
    
    $builder
      ->add('address', 'text', array('label'  => 'Адрес:', 'required' => FALSE))
      ->add('phone', 'text', array('label'  => 'Телефон:', 'required' => FALSE))
      ->add('site', 'text', array('label'  => 'Сайт:', 'required' => FALSE))
      ->add('fos_user_id', 'text', array('label'  => 'Пользователь:', 'required' => FALSE))
      ->add('description', 'textarea', array('label'  => 'Краткое описание:', 'required' => FALSE))
      ->add('icon', 'file', array('label'  => 'Изображение:', 'required' => false, 'data_class' => NULL))
      ->add('enabled', 'checkbox', array('label'  => 'Включено:', 'required' => FALSE))
      ->add('save', 'submit', array('label'  => 'Сохранить'))      
      ->getForm();
  }

  public function getName() {
    return 'shops';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Admin\AdminBundle\Model\Shops'
    ));
  }
}
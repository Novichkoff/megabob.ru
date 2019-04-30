<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ShopsType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('name', 'text', array('label'  => 'Название компании', 'required' => TRUE, 'attr' => array('class' => 'form-control check')))
      ->add('title', 'text', array('label'  => 'Заголовок', 'required' => TRUE, 'attr' => array('class' => 'form-control check')));

    # Выбор Региона
    $areas = AreasQuery::create()->orderByName()->find();
    $areas_array = array();
    foreach ($areas as $area)
    {
      $areas_array[$area->getId()] = $area->getName();
    }

    $current_area = (@$options['data']->area_id) ? $options['data']->area_id : 0;    

    $builder->add('area_id', 'choice', array(
      'choices' => $areas_array,
      'empty_value' => 'выберите регион',
      'label' => 'Регион',
      'help' => 'Выберите регион местонахождения компании',
      'attr' => array('class' => 'changeable_s selectpicker form-control check', 'data-live-search' => 'true'),
      'data' => $current_area,
      'mapped' => false,
      'required' => true));

    if ($current_area)
    {
      $regions = RegionsQuery::create()->filterByAreaId($current_area)->orderByType()->orderByName()->find();
      $regions_array = array();
      foreach ($regions as $region)
      {
        $regions_array[$region->getId()] = $region->getName();
      }

      $builder->add('region_id', 'choice', array(
        'choices' => $regions_array,
        'empty_value' => 'выберите город',
        'label' => 'Город',
        'help' => 'Выберите город местонахождения компании',
        'attr' => array('class' => 'form-control selectpicker check', 'data-live-search' => 'true'),        
        'required' => true));
    }
    
    $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event)
    {
      $form = $event->getForm(); $data = $event->getData();
      # Выбор Города
      if (@$data['area_id']) {
        $regions = RegionsQuery::create()->filterByAreaId($data['area_id'])->orderByType()->orderByName()->find(); 
        $regions_array = array();
        foreach ($regions as $region) {
            $regions_array[$region->getId()] = $region->getName();
        }        
        $form->add('region_id', 'choice', array(
          'choices' => $regions_array,
          'empty_value' => 'выберите город',
          'label' => 'Город',
          'help' => 'Выберите город местонахождения компании',
          'attr' => array('class' => 'form-control selectpicker check', 'data-live-search' => 'true'),          
          'required' => true));
      }
    
    });
    
    $builder
      ->add('address', 'text', array('label'  => 'Адрес', 'required' => FALSE, 'attr' => array('class' => 'form-control')))
      ->add('phone', 'text', array('label'  => 'Телефон', 'required' => TRUE, 'attr' => array('class' => 'form-control check','data-inputmask' => "'mask': '+9(999)999-9999'")))
      ->add('site', 'text', array('label'  => 'Сайт', 'required' => FALSE, 'attr' => array('class' => 'form-control')))
      ->add('fos_user_id', 'hidden', array('label'  => 'Пользователь', 'required' => FALSE))
      ->add('description', 'textarea', array('label'  => 'Описание деятельности', 'required' => FALSE))
      ->add('icon', 'file', array('label'  => 'Логотип компании', 'required' => false, 'data_class' => NULL))
      ->add('enabledd','hidden', array('mapped' => false))
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
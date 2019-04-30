<?php

namespace Admin\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use Admin\AdminBundle\Model\AdCategoriesQuery;

class SettingsType extends AbstractType{    
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('name', 'text', array('label'  => 'Название:', 'required' => TRUE))
      ->add('title', 'text', array('label'  => 'Заголовок:', 'required' => TRUE))
      ->add('url', 'text', array('label'  => 'URL:', 'required' => TRUE))
      ->add('description', 'text', array('label'  => 'Краткое описание:', 'required' => FALSE))
      ->add('keywords', 'text', array('label'  => 'Ключевые слова:', 'required' => FALSE))
      ->add('content', 'textarea', array('label' => 'Контент', 'required'  => false))
      ->add('robots', 'textarea', array('label'  => 'robots.txt:', 'required' => FALSE))
      ->add('counters', 'textarea', array('label'  => 'Счетчики:', 'required' => FALSE))
      ->add('fb', 'text', array('label'  => 'Facebook:', 'required' => FALSE))
      ->add('vk', 'text', array('label'  => 'ВКонтакте:', 'required' => FALSE))
      ->add('twitter', 'text', array('label'  => 'Twitter:', 'required' => FALSE))
      ->add('logo', 'file', array('label'  => 'Логотип:', 'required' => false, 'data_class' => NULL))
      ->add('icon', 'file', array('label'  => 'Иконка:', 'required' => false, 'data_class' => NULL))
      ->add('save', 'submit', array('label'  => 'Сохранить',))
      ->getForm();
  }

  public function getName() {
    return 'settings';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Admin\AdminBundle\Model\Settings'
      ));
  }
}
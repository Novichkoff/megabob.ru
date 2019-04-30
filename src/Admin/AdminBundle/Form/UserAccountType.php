<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserAccountType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('balance', 'text', array('label'  => 'Баланс:', 'required' => TRUE))
      ->add('bonus', 'text', array('label'  => 'Бонусы:', 'required' => TRUE))
      ->getForm();
  }

  public function getName() {
    return 'user_account';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Admin\AdminBundle\Model\UserAccount'
    ));
  }
}
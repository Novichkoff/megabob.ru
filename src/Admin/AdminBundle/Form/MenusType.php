<?php
namespace Admin\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use Admin\AdminBundle\Model\AdCategoriesQuery;

class MenusType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('name', 'text', array('label'  => 'Название:', 'required' => TRUE))
    ->add('path', 'text', array('label'  => 'Алиас:', 'required' => TRUE))
    ->add('save', 'submit', array('label'  => 'Сохранить',))
    ->getForm();
  }

  public function getName() {
    return 'menu';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Admin\AdminBundle\Model\Menu'
    ));
  }
}
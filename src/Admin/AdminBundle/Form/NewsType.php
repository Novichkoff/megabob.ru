<?php

namespace Admin\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use Admin\AdminBundle\Model\AdCategoriesQuery;

class NewsType extends AbstractType{    
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title', 'text', array('label'  => 'Заголовок:', 'required' => TRUE))
      ->add('alias', 'text', array('label'  => 'Алиас:', 'required' => TRUE))
      ->add('description', 'textarea', array('label'  => 'Краткое описание:', 'required' => FALSE))
      ->add('content', 'genemu_tinymce', array(
        'label'     => 'Контент',
        'required'  => false,
        'configs'   => array(
          'language'                =>'ru',
          'height'                  => 400,
          'plugins'                 => array(
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
          ),
          'theme_advanced_buttons1' => 'bold,italic,underline,undo,redo,link,unlink,forecolor,styleselect,removeformat,cleanup,code',
          )
        )
      )
      ->add('icon', 'file', array('label'  => 'Изображение:', 'required' => false, 'data_class' => NULL))
      ->add('save', 'submit', array('label'  => 'Сохранить',))
      ->getForm();
  }

  public function getName() {
    return 'news';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Admin\AdminBundle\Model\News'
      ));
  }
}
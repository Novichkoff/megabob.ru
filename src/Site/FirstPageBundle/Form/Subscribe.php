<?php

namespace Site\FirstPageBundle\Form;

use \Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Symfony\Component\Security\Core\SecurityContext;

class Subscribe extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if (@$options['data']) {
            $category_id = $options['data']['subscribe']->getCategoryId();
            $area_id = $options['data']['subscribe']->getAreaId();
			$town_id = $options['data']['subscribe']->getTownId();
        }		
		
		$builder
      ->add('category_id', 'hidden', array('data' => $category_id))
			->add('area_id', 'hidden', array('data' => $area_id))
			->add('town_id', 'hidden', array('data' => $town_id));			
		if (@$options['data']['user']) {
			$builder->add('email', 'text', array('attr'=>array('placeholder' => 'Введите Email'), 'required' => TRUE, 'data' => $options['data']['user']->getEmail()));
		} else {
			$builder->add('email', 'text', array('attr'=>array('placeholder' => 'Введите Email'), 'required' => TRUE));
		}   
		$builder->add('save', 'submit', array('label'  => 'Подписаться','attr'=>array('class'=>'form-control btn btn-primary')));		

        $builder
            ->getForm();

    }

    public function getName()
    {

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
        ));
    }

}

<?php

namespace Site\FirstPageBundle\Form;

use \Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class Comment extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if (@$options['data']) {
            $adv_id = $options['data']->getAdvId();
            $fos_user_id = $options['data']->getFosUserId();
        }

        $builder
            ->add('adv_id', 'hidden', array('data' => $adv_id))
            ->add('fos_user_id', 'hidden', array('data' => $fos_user_id))
            ->add('comment', 'textarea', array('label' => 'Добавить новую:', 'required' => TRUE));

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

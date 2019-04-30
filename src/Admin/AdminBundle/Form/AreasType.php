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
use Symfony\Component\HttpFoundation\File\File;

class AreasType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', 'text', array('label'  => 'Название области',))
            ->add('pagetitle', 'text', array('label'  => 'Тескт для заголовка',))
            ->add('code', 'text', array('label'  => 'Код региона', 'required' => FALSE))
			->add('part', 'choice', array(
                'choices'   => array( 1 => 'Восточная часть', 2 => 'Западная часть'),
                'label'  => 'Часть России',
            ))
			->add('path', 'textarea', array('label'  => 'Код полигона', 'required' => FALSE))
            ->add('save', 'submit', array('label'  => 'Сохранить',))
            ->getForm();

    }

    public function getName()
    {
        return 'areas';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Areas',
        ));
    }

}

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
use Admin\AdminBundle\Model\AreasQuery;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;

class RegionsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $areas = AreasQuery::create()
            ->orderByName()
            ->findByDeleted(0);
        $areas_array = array();
        $areas_array[0]='';
        foreach ($areas as $area) {

            $areas_array[$area->getId()] = $area->getName();

        }

        $builder
            ->add('name', 'text', array('label'  => 'Название',))
            ->add('area_id', 'choice', array(
                'choices'   => $areas_array,
                'label'  => 'Область',
            ))
            ->add('icon', 'file', array('label'  => 'Герб города', 'required' => FALSE))
            ->add('type', 'choice', array(
                'choices'   => array( 1 => 'Федеральный центр', 2 => 'Областной центр', 3 => 'Населенный пункт'),
                'label'  => 'Тип',
            ))
            ->add('pagetitle', 'text', array('label'  => 'Текст для заголовка'))
            ->add('net', 'text', array('label'  => 'Родительный падеж'))
            ->add('alias', 'text', array('label'  => 'Алиас'))
            ->add('weather', 'text', array('label'  => 'Код города (Gismeteo)', 'required' => FALSE))
            ->add('save', 'submit', array('label'  => 'Сохранить',))
            ->getForm();

    }

    public function getName()
    {
        return 'regions';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Regions',
        ));
    }

}

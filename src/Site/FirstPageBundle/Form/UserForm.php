<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Site\FirstPageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserForm extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
            $constraint = new UserPassword();
        } else {
            $constraint = new OldUserPassword();
        }

        $this->buildUserForm($builder, $options);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'profile',
        ));
    }

    public function getName()
    {
        return 'fos_user_profile';
    }


    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle', 'read_only' => TRUE,'attr'=>array('class'=>'form-control')))            
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle','required' => TRUE,'attr'=>array('class'=>'form-control')))
            ->add('realname', 'text', array('label' => 'Имя','required' => TRUE,'attr'=>array('class'=>'form-control')))
            ->add('phone', 'text', array('label' => 'Телефон','required' => TRUE,'attr'=>array('class'=>'form-control')))
			->add('skype', 'text', array('label' => 'Skype','required' => FALSE,'attr'=>array('class'=>'form-control')))
			->add('email_status', 'checkbox', array('label' => 'Email уведомления','required' => FALSE))			
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                'required' => FALSE,
                'attr'=>array('class'=>'form-control')
            ));

    }
}

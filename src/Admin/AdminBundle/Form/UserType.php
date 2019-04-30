<?php
/* * This file is part of the FOSUserBundle package. 
* * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/> 
* * For the full copyright and license information, please view the LICENSE 
* file that was distributed with this source code. */

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;

class UserType extends AbstractType{    
	public function buildForm(FormBuilderInterface $builder, array $options){
        if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
            $constraint = new UserPassword();
		} else {
            $constraint = new OldUserPassword();
		}
        $builder
			->add('username_canonical', 'text', array('label'  => 'Ваше имя:'));
		$this->buildUserForm($builder, $options);
	}
	
    public function getName() {
        return 'fos_user_profile';
	}
	
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
			'data_class' => $this->class,
            'intention'  => 'profile',
		));
	}
}
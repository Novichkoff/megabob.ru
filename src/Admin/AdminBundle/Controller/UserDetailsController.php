<?php

namespace Admin\AdminBundle\Controller;

use Admin\AdminBundle\Model\UserAccountQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\UserCouponsQuery;
use Admin\AdminBundle\Model\UserAccount;
use Admin\AdminBundle\Form\UserAccountType;
use Admin\AdminBundle\Model\UserMessagesQuery;

class UserDetailsController extends Controller
{

    public function indexAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $id));
        if(!$user) {
            throw new NotFoundHttpException('Пользователь отсутствует!');
        }

        $sending_mails = $user->getEmailSendCnt();
        $user_account = UserAccountQuery::create()
            ->findOneByFosUserId($user->getId());
        if (!$user_account) {
          $user_account = new UserAccount();
          $user_account->setFosUserId($user->getId());
        }
            
        $balance_form = $this->createForm(new UserAccountType(), $user_account);

        $balance_form->handleRequest($request);   

        $user_shops = ShopsQuery::create()
            ->filterByFosUserId($user->getId())
            ->find();
        
        $user_advs = AdvsQuery::create()
            ->filterByUserId($user->getId())
            ->find();
		
        $user_messages = UserMessagesQuery::create()
            ->filterByFosUserId($user->getId())
            ->orderByDate('DESC')			
            ->find();

        $formFactory = $this->container->get('fos_user.profile.form.factory');
        
        $form = $formFactory->createForm();
        $form->add('password_requested_at', 'date', array('widget' => 'single_text','label'  => 'Сброс пароля:', 'attr' => array('placeholder'=>'Сброс пароля', 'class'=>'form-control'), 'required' => FALSE));
        $form->add('last_login', 'date', array('widget' => 'single_text','label'  => 'Последний вход:', 'attr' => array('placeholder'=>'последний вход', 'class'=>'form-control'), 'required' => FALSE));		
        $form->add('locked', 'checkbox', array('label' => 'Блокировка:', 'required' => FALSE));
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->container->get('fos_user.user_manager')->updateUser($user);
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Данные пользователя успешно обновлены!'
            );
            return $this->redirect($this->generateUrl('admin_admin_userspage'));

        }
        
        if ($balance_form->isValid()) {

            $user_account->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Баланс пользователя успешно обновлен!'
            );            

        }

        return $this->render('AdminAdminBundle:UserDetails:index.html.twig', array(
            'form'              => $form->createView(),
            'balance_form'    	=> $balance_form->createView(),
            'for_moders'        => $for_moders,
            'account'           => $user_account,
            'sending_mails'		=> $sending_mails,
            'shops'             => $user_shops,
            'advs'              => $user_advs,
			'messages'			=> $user_messages
        ));
    }

    public function addAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $user = $this->container->get('fos_user.user_manager')->createUser();

        $formFactory = $this->container->get('fos_user.registration.form.factory');

        $form = $formFactory->createForm();
        $form->add('realname', 'text', array('label'  => 'Имя:', 'required' => TRUE));
        $form->add('phone', 'text', array('label'  => 'Номер телефона:', 'required' => FALSE));
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user->setEnabled(true);
            $this->container->get('fos_user.user_manager')->updateUser($user);
            $user_account = new UserAccount();
            $user_account->setFosUserId($user->getId());
            $user_account->save();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Пользователь успешно добавлен!'
            );
            return $this->redirect($this->generateUrl('admin_admin_userspage'));
        }

        return $this->render('AdminAdminBundle:UserDetails:registration.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    public function deleteAction($id)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $id));

        if(!$user) {
            throw new NotFoundHttpException('Пользователь отсутствует!');
        }

        $user_account = UserAccountQuery::create()->findOneByFosUserId($user->getId());
        if ($user_account) $user_account->delete();

        $this->container->get('fos_user.user_manager')->deleteUser($user);

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Пользователь успешно удален!'
        );

        return $this->redirect($this->generateUrl('admin_admin_userspage'));
    }
}
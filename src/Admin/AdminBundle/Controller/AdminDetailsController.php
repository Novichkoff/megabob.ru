<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Admin\AdminBundle\Model\AdvsQuery;

class AdminDetailsController extends Controller
{

    public function indexAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $id));
        if(!$user) {
            throw new NotFoundHttpException('Администратор отсутствует!');
        }

        $formFactory = $this->container->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->container->get('fos_user.user_manager')->updateUser($user);
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Данные администратора успешно обновлены!'
            );
            return $this->redirect($this->generateUrl('admin_admin_adminspage'));

        }

        return $this->render('AdminAdminBundle:AdminDetails:index.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    public function addAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $user = $this->container->get('fos_user.user_manager')->createUser();

        $formFactory = $this->container->get('fos_user.registration.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->container->get('fos_user.user_manager')->updateUser($user);
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Администратор успешно добавлен!'
            );
            return $this->redirect($this->generateUrl('admin_admin_adminspage'));
        }

        return $this->render('AdminAdminBundle:AdminDetails:registration.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    public function deleteAction($id)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $id));

        if(!$user) {
            throw new NotFoundHttpException('Администратор отсутствует!');
        }

        $this->container->get('fos_user.user_manager')->deleteUser($user);

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Администратор успешно удален!'
        );

        return $this->redirect($this->generateUrl('admin_admin_adminspage'));
    }
}
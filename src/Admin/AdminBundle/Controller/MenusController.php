<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\MenuQuery;
use Admin\AdminBundle\Model\Menu;
use Admin\AdminBundle\Form\MenusType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MenusController extends Controller
{
    # Вывод всех пунктов меню
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $menus = MenuQuery::create()
            ->find();
        if (!$menus) {
            throw $this->createNotFoundException(
                'Нет доступных пунктов меню'
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $menus,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Menus:index.html.twig',array(
                'pagination' 		=> $pagination,
                'for_moders' 	    => $for_moders
            )
        );
    }

    # Добавление пункта меню
    public function createAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $menu = new Menu();

        $form = $this->createForm(new MenusType(), $menu);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $menu->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Пункт меню успешно добавлен!'
            );

            return $this->redirect($this->generateUrl('admin_admin_menuspage'));
        }

        return $this->render('AdminAdminBundle:Menus:add.html.twig', array(
                'form'              => $form->createView(),
                'for_moders'        => $for_moders
            )
        );
    }

    # Редактирование пункта меню
    public function editAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $menu = MenuQuery::create()
            ->findOneById($id);
        if(!$menu) {
            throw new NotFoundHttpException('Пункт меню отсутствует!');
        }

        $form = $this->createForm(new MenusType(), $menu);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $menu->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Пункт меню успешно изменен!'
            );

            return $this->redirect($this->generateUrl('admin_admin_menuspage'));
        }

        return $this->render('AdminAdminBundle:Menus:edit.html.twig', array(
                'form'              => $form->createView(),
                'for_moders'        => $for_moders
            )
        );
    }

    # Удаление пункта меню
    public function deleteAction($id)
    {
        $menu = MenuQuery::create()->findOneById($id);
        if(!$menu) {
            throw new NotFoundHttpException('Пункт меню отсутствует!');
        }

        $title = $menu->getName();
        $menu->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Пункт "'.$title.'" успешно удален из меню!'
        );

        return $this->redirect($this->generateUrl('admin_admin_menuspage'));
    }

}

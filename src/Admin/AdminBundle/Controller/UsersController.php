<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Propel\UserQuery;

class UsersController extends Controller
{
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $users = UserQuery::create()            
            ->find();
            
        $all_users = array();
        if ($users) foreach ($users as $user) {
            $all_users[] = $user->getUsername();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Users:index.html.twig',array(
            'pagination'        => $pagination,
            'for_moders'        => $for_moders,
            'all_users'         => $all_users
        ));
    }

    public function findAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $users = $this->container->get('fos_user.user_manager')->findUsers();
        $all_users = array();
        foreach ($users as $user) {
            $all_users[] = $user->getUsername();
        }

        $query = @$request->query;
        if (@$query->get('username')) {
            $user = $this->container->get('fos_user.user_manager')->findUserByUsername($query->get('username'));
        }

        return $this->render('AdminAdminBundle:Users:find.html.twig',array(
            'user'              => $user,
            'for_moders'        => $for_moders,
            'all_users'         => $all_users
        ));
    }

}

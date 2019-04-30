<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\AdvsQuery;

class AdminsController extends Controller
{
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $admins = UserQuery::create()            
            ->filterByRoles(array('role' => 'ROLE_SUPER_ADMIN'))
            ->find();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $admins,
            $this->get('request')->query->get('page', 1),
            10
        );

        return $this->render('AdminAdminBundle:Admins:index.html.twig',array('pagination' => $pagination, 'for_moders' => $for_moders));
    }

}

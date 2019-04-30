<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\Packets;
use Admin\AdminBundle\Model\PacketsQuery;
use Admin\AdminBundle\Form\PacketsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PacketsController extends Controller
{
    # Вывод всех пакетов
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $packets = PacketsQuery::create()
            ->find();
        if (!$packets) {
            throw $this->createNotFoundException(
                'Нет доступных пакетов'
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $packets,
            $this->get('request')->query->get('page', 1),
            20
        );

		return $this->render('AdminAdminBundle:Packets:index.html.twig',array(
			'pagination' 		=> $pagination,
			'for_moders' 	    => $for_moders
		    )
        );
    }

	# Редактирование пакета
    public function editAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $packet = PacketsQuery::create()
            ->findOneById($id);
        if(!$packet) {
            throw new NotFoundHttpException('Пакет отсутствует!');
        }

        $form = $this->createForm(new PacketsType(), $packet);
        $form->handleRequest($request);
        if ($form->isValid()) {

          $packet->save();
          $this->get('session')->getFlashBag()->add(
            'notice1',
            'Пакет успешно изменен!'
          );

          return $this->redirect($this->generateUrl('admin_admin_packetspage'));
        }

        return $this->render('AdminAdminBundle:Packets:edit.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
            )
        );
    }

}


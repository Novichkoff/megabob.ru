<?php

namespace Admin\AdminBundle\Controller;

use \Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\Shops;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Form\ShopsType;
use Admin\AdminBundle\Form\ShopsFullType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ShopsController extends Controller
{

    # Магазины - Главная
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $shops = ShopsQuery::create()
            ->orderByEnabled("asc")
			->find();
        if (!$shops) {
            throw $this->createNotFoundException(
                'Нет доступных магазинов'
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $shops,
            $this->get('request')->query->get('page', 1),
            20
        );

		return $this->render('AdminAdminBundle:Shops:index.html.twig',array(
			'pagination' 		=> $pagination,
			'for_moders' 	    => $for_moders
		    )
        );
    }

    # Добавление магазина
    public function createAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $shop = new Shops();

        $form = $this->createForm(new ShopsFullType(), $shop);
        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($form['region_id']->getData() == 0) { $shop->setRegionId(NULL);}
            $shop->save();

            if ($form['icon']->getData()) {
                $dir = 'images/shops/images';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $shop->setIcon($Filename);
                    $shop->save();

                    $image = new Image($dir.'/'.$Filename);
                    $image->fit_to_width(400);
                    $image->save($dir.'/'.$Filename);
                }

            }

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Магазин успешно сохранен!'
            );

            return $this->redirect($this->generateUrl('admin_admin_shopshomepage'));
        }

        return $this->render('AdminAdminBundle:Shops:add.html.twig', array(
                'form'              => $form->createView(),
                'for_moders'        => $for_moders
            )
        );
    }

	# Редактирование магазина
    public function editAction($id, Request $request)
    {
        $shop = ShopsQuery::create()
            ->findOneById($id);
        if(!$shop) {
            throw new NotFoundHttpException('Магазин отсутствует!');
        }

        $icon = $shop->getIcon();

        $form = $this->createForm(new ShopsFullType(), $shop);
        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/shops/images';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $shop->setIcon($Filename);
                    $shop->save();

                    $image = new Image($dir.'/'.$Filename);
                    $image->fit_to_width(300);
                    $image->save($dir.'/'.$Filename);
                    unset($image);
                }

            } else {
                $shop->setIcon($icon);
            }
            if ($form['region_id']->getData() == 0) { $shop->setRegionId(NULL);}
            $shop->save();

          $this->get('session')->getFlashBag()->add(
            'notice1',
            'Магазин успешно изменен!'
          );

          return $this->redirect($this->generateUrl('admin_admin_shopshomepage'));
        }

        $image = $shop->getIcon();
		
		# Для модератора
        $for_moders = $this->get('for_moders')->build();

        return $this->render('AdminAdminBundle:Shops:edit.html.twig', array(
                'id'                => $id,
                'image'             => $image,
                'form'              => $form->createView(),
                'for_moders'        => $for_moders
            )
        );
    }

    # Удаление купона
    public function deleteAction($id)
    {
        $shop = ShopsQuery::create()->findOneById($id);
        if(!$shop) {
            throw new NotFoundHttpException('Магазин отсутствует!');
        }

        $name = $shop->getName();

        # Удаление изображения
        $dir = 'images/shops/images';
        $Filename = $shop->getIcon();

        if ($Filename) {
          $fs = new Filesystem();
          try {
              $fs->remove( $dir.'/'.$Filename );
          } catch (IOExceptionInterface $e) {
              echo "Ошибка удаления изображения ".$e->getPath();
          }
        }

        $shop->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Магазин "'.$name.'" успешно удален!'
        );

        return $this->redirect($this->generateUrl('admin_admin_shopshomepage'));
    }

}
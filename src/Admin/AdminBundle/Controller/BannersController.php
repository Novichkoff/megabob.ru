<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\Banners;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Form\BannersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class BannersController extends Controller
{
    # Вывод всех баннеров
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $banners = BannersQuery::create()->findByDeleted(0);
        if (!$banners) {
            throw $this->createNotFoundException(
                'Нет доступных баннеров'
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $banners,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Banners:index.html.twig',array(
                'pagination' 		=> $pagination,
                'for_moders' 	    => $for_moders
            )
        );
    }

    # Создание нового баннера
    public function createAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $banner = new Banners();
        $form = $this->createForm(new BannersType(), $banner);
        $form->handleRequest($request);
        if ($form->isValid()) {

            # Если загрузили изображение - обрабатываем его
            if ($form['picture']->getData()) {
                $dir = 'images/banners';
                $file_type = $form['picture']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['picture']->getData()->move($dir, $Filename);
                    $banner->setPicture($Filename);
                }

            }
            $banner->save();

            # Вставляем дату публикации при активации баннера
            if ($banner->getEnabled() == TRUE) $banner->setPublishDate(date("Y-m-d H:i:s"));
            $banner->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Баннер успешно добавлен!'
            );

            return $this->redirect($this->generateUrl('admin_admin_bannerspage'));
        }

        return $this->render('AdminAdminBundle:Banners:add.html.twig', array(
                'form'              => $form->createView(),
                'for_moders'        => $for_moders
            )
        );
    }

    # Редактирование баннера
    public function editAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $banner = BannersQuery::create()->findOneById($id);
        if(!$banner) {
            throw new NotFoundHttpException('Баннер отсутствует!');
        }
        # Если было изображение - сохраняем его и очищаем от него баннер.
        $picture = $banner->getPicture();
        $banner->setPicture('');

        $banner_enabled = $banner->getEnabled();
        $banner->setCode(stripslashes($banner->getCode()));
        $form = $this->createForm(new BannersType(), $banner);
        $form->handleRequest($request);
        if ($form->isValid()) {

            # Если загрузили изображение - обрабатываем его
            if ($form['picture']->getData()) {
                $dir = 'images/banners';
                $file_type = $form['picture']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['picture']->getData()->move($dir, $Filename);
                    $banner->setPicture($Filename);
					# Удаляем старое изображение
					if ($picture) {
					  $fs = new Filesystem();
					  try {
						  $fs->remove( $dir.'/'.$picture );
					  } catch (IOExceptionInterface $e) {
						  echo "Ошибка удаления изображения ".$e->getPath();
					  }
					}
                }

            } else {
                $banner->setPicture($picture);
            }
            $banner->save();

            # Вставляем дату публикации при активации баннера
            if ($banner->getEnabled() != $banner_enabled && $banner->getEnabled() == TRUE) $banner->setPublishDate(date("Y-m-d H:i:s"));
            $banner->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Баннер успешно изменен!'
            );

            return $this->redirect($this->generateUrl('admin_admin_bannerspage'));
        }

        return $this->render('AdminAdminBundle:Banners:edit.html.twig', array(
                'form'              => $form->createView(),
                'picture'           => $picture,
                'for_moders'        => $for_moders
            )
        );
    }

    # Удаление баннера
    public function deleteAction($id)
    {
        $banner = BannersQuery::create()->findOneById($id);
        if(!$banner) {
            throw new NotFoundHttpException('Баннер отсутствует!');
        }

        $dir = 'images/banners';
        $Filename = $banner->getPicture();
        if ($Filename) {
          $fs = new Filesystem();
          try {
              $fs->remove( $dir.'/'.$Filename );
          } catch (IOExceptionInterface $e) {
              echo "Ошибка удаления изображения ".$e->getPath();
          }
        }

        $banner->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Баннер "'.$banner->getName().'" успешно удален!'
        );

        return $this->redirect($this->generateUrl('admin_admin_bannerspage'));
    }

}
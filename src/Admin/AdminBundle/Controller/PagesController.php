<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\Pages;
use Admin\AdminBundle\Model\PagesQuery;
use Admin\AdminBundle\Form\PagesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class PagesController extends Controller
{
    # Вывод всех страниц
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $pages = PagesQuery::create()
            ->find();
        if (!$pages) {
            throw $this->createNotFoundException(
                'Нет доступных страниц'
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $pages,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Pages:index.html.twig',array(
                'pagination' 		=> $pagination,
                'for_moders' 	    => $for_moders
            )
        );
    }

    # Добавление страницы
    public function createAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $page = new Pages();

        $form = $this->createForm(new PagesType(), $page);
        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/pages/images';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $page->setIcon($Filename);
                    $page->save();

                    $image = new Image($dir.'/'.$Filename);
                    $image->thumbnail_full(300, 225);                      
                    $image->save($dir.'/'.$Filename);
                }

            }
            
            $page->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Страница успешно добавлена!'
            );

            return $this->redirect($this->generateUrl('admin_admin_pagespage'));
        }

        return $this->render('AdminAdminBundle:Pages:add.html.twig', array(
                'form'              => $form->createView(),
                'for_moders'        => $for_moders
            )
        );
    }

    # Редактирование страницы
    public function editAction($id, Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $page = PagesQuery::create()
            ->findOneById($id);
        if(!$page) {
            throw new NotFoundHttpException('Страница отсутствует!');
        }
        
        $icon = $page->getIcon();

        $form = $this->createForm(new PagesType(), $page);
        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/pages/images';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $page->setIcon($Filename);
                    $page->save();

                    $image = new Image($dir.'/'.$Filename); 
                    $image->thumbnail_full(300, 225);  
                    $image->save($dir.'/'.$Filename);
                    unset($image);
                }

            } else {
                $page->setIcon($icon);
            }
            
            $page->save();
            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Страница успешно изменена!'
            );

            return $this->redirect($this->generateUrl('admin_admin_pagespage'));
        }
        
        $image = $page->getIcon();

        return $this->render('AdminAdminBundle:Pages:edit.html.twig', array(
                'form'              => $form->createView(),
                'image'             => $image,
                'for_moders'        => $for_moders
            )
        );
    }

    # Удаление страницы
    public function deleteAction($id)
    {
        $page = PagesQuery::create()->findOneById($id);
        if(!$page) {
            throw new NotFoundHttpException('Страница отсутствует!');
        }

        # Удаление изображения
        $dir = 'images/pages/images';
        $Filename = $page->getIcon();

        if ($Filename) {
          $fs = new Filesystem();
          try {
              $fs->remove( $dir.'/'.$Filename );
          } catch (IOExceptionInterface $e) {
              echo "Ошибка удаления изображения ".$e->getPath();
          }
        }
        
        $title = $page->getTitle();
        $page->delete();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Страница "'.$title.'" успешно удалена!'
        );

        return $this->redirect($this->generateUrl('admin_admin_pagespage'));
    }

}

<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\News;
use Admin\AdminBundle\Model\NewsQuery;
use Admin\AdminBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class NewsController extends Controller
{
    # Вывод всех страниц
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $pages = NewsQuery::create()
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

        return $this->render('AdminAdminBundle:News:index.html.twig',array(
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

        $page = new News();

        $form = $this->createForm(new NewsType(), $page);
        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/news/images';
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

            return $this->redirect($this->generateUrl('admin_admin_newspage'));
        }

        return $this->render('AdminAdminBundle:News:add.html.twig', array(
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

        $page = NewsQuery::create()
            ->findOneById($id);
        if(!$page) {
            throw new NotFoundHttpException('Страница отсутствует!');
        }
        
        $icon = $page->getIcon();

        $form = $this->createForm(new NewsType(), $page);
        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/news/images';
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

            return $this->redirect($this->generateUrl('admin_admin_newspage'));
        }
        
        $image = $page->getIcon();

        return $this->render('AdminAdminBundle:News:edit.html.twig', array(
                'form'              => $form->createView(),
                'image'             => $image,
                'for_moders'        => $for_moders
            )
        );
    }

    # Удаление страницы
    public function deleteAction($id)
    {
        $page = NewsQuery::create()->findOneById($id);
        if(!$page) {
            throw new NotFoundHttpException('Страница отсутствует!');
        }

        # Удаление изображения
        $dir = 'images/news/images';
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

        return $this->redirect($this->generateUrl('admin_admin_newspage'));
    }

}

<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\Areas;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Admin\AdminBundle\Form\RegionsType;
use Admin\AdminBundle\Form\AreasType;
use Admin\AdminBundle\Controller\Image;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\JobsQuery;

class RegionsController extends Controller
{
    public function indexAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        return $this->render('AdminAdminBundle:Regions:index.html.twig',array('for_moders' => $for_moders) );
    }

    # Отображение всех Городов
    public function citiesAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $regions = RegionsQuery::create()
            ->joinAreas()
            ->orderByName()
            ->findByDeleted(0);

        if (!$regions) {
            throw $this->createNotFoundException(
                'Нет доступных регионов'
            );
        }

        $all_cities = array();
        foreach ($regions as $region) {
            $all_cities[] = $region->getName();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $regions,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Regions:cities.html.twig',array(
            'pagination'    => $pagination,
            'all_cities'    => $all_cities,
            'for_moders'    => $for_moders
        ));
    }

    # Отображение всех Городов
    public function findCityAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $regions = RegionsQuery::create()
            ->joinAreas()
            ->findByDeleted(0);

        if (!$regions) {
            throw $this->createNotFoundException(
                'Нет доступных регионов'
            );
        }

        $all_cities = array();
        foreach ($regions as $region) {
            $all_cities[] = $region->getName();
        }

        $query = @$request->query;
        if (@$query->get('city')) {
            $regions = RegionsQuery::create()
                ->joinAreas()
                ->filterByName($query->get('city'))
                ->findByDeleted(0);
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $regions,
            $this->get('request')->query->get('page', 1),
            20
        );

        return $this->render('AdminAdminBundle:Regions:cities.html.twig',array(
            'pagination'    => $pagination,
            'all_cities'    => $all_cities,
            'for_moders'    => $for_moders
        ));
    }

    # Отображение всех Областей
    public function areasAction()
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $areas = AreasQuery::create()
            ->orderByName()
            ->findByDeleted(0);

        if (!$areas) {
            throw $this->createNotFoundException(
                'Нет доступных областей'
            );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $areas,
            $this->get('request')->query->get('page', 1),
            200
        );

        return $this->render('AdminAdminBundle:Regions:areas.html.twig',array('pagination' => $pagination, 'for_moders' => $for_moders) );
    }

    # Редактирование Города

    public function editAction($id, Request $request)
    {

        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $region = RegionsQuery::create()
            ->joinAreas()
            ->findPk($id);

        if(!$region) {
            throw new NotFoundHttpException('Регион отсутствует!');
        }
        $icon = $region->getIcon();
        $region->setIcon('');

        $form = $this->createForm(new RegionsType(),$region);

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($form['icon']->getData()) {
                $dir = 'images/regions';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $region->setIcon($Filename);

                    $image = new Image($dir.'/'.$Filename);
                    $image->fit_to_height(30);
                    $image->save($dir.'/'.$Filename);
                }

            } else { $region->setIcon($icon); }

            $region->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Населенный пункт "'.$region->getName().'" успешно изменен!'
            );
            return $this->redirect($this->generateUrl('admin_admin_citiespage'));

        }

        return $this->render('AdminAdminBundle:Regions:edit.html.twig', array(
            'form'              => $form->createView(),
            'icon'              => $icon,
            'for_moders'        => $for_moders
        ));
    }

    # Создание нового Города

    public function createAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $region = new Regions();

        $form = $this->createForm(new RegionsType(), $region);

        $form->handleRequest($request);

        if ($form->isValid()) {

            # Добавление герба региона (города)

            if ($form['icon']->getData()) {
                $dir = 'images/regions';
                $file_type = $form['icon']->getData()->getMimeType();
                switch($file_type) {
                    case 'image/png': $Filename = uniqid().'.png'; break;
                    case 'image/jpeg': $Filename = uniqid().'.jpg'; break;
                    case 'image/gif': $Filename = uniqid().'.gif'; break;
                }

                if ($Filename) {
                    $form['icon']->getData()->move($dir, $Filename);
                    $region->setIcon($Filename);

                    $image = new Image($dir.'/'.$Filename);
                    $image->fit_to_height(30);
                    $image->save($dir.'/'.$Filename);
                }

            }

            $region->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Населенный пункт "'.$region->getName().'" успешно добавлен!'
            );
            return $this->redirect($this->generateUrl('admin_admin_citiespage'));

        }

        return $this->render('AdminAdminBundle:Regions:add.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    # Удаление Города

    public function deleteAction($id)
    {
        $region = RegionsQuery::create()->findOneById($id);
        if(!$region) {
            throw new NotFoundHttpException('Регион отсутствует!');
        }

        # Удаление герба региона (города)
        $dir = 'images/regions';
        $Filename = $region->getIcon();

        $fs = new Filesystem();
        try {
            $fs->remove( $dir.'/'.$Filename );
        } catch (IOExceptionInterface $e) {
            echo "Ошибка удаления изображения ".$e->getPath();
        }

        $region->setDeleted(1);
        $region->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Населенный пункт "'.$region->getName().'" успешно удален! Изображение "'.$dir.'/'.$Filename.'" успешно удалено!'
        );

        return $this->redirect($this->generateUrl('admin_admin_regionspage'));
    }


    # Редактирование Области
    public function editAreaAction($id, Request $request)
    {

        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $area = AreasQuery::create()
            ->findPk($id);

        if(!$area) {
            throw new NotFoundHttpException('Область отсутствует!');
        }

        $form = $this->createForm(new AreasType(),$area);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $area->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Область "'.$area->getName().'" успешно изменена!'
            );
            return $this->redirect($this->generateUrl('admin_admin_areaspage'));
        }

        return $this->render('AdminAdminBundle:Regions:edit_area.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    # Создание новой Области

    public function createAreaAction(Request $request)
    {
        # Для модератора
        $for_moders = $this->get('for_moders')->build();

        $area = new Areas();

        $form = $this->createForm(new AreasType(), $area);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $area->save();

            $this->get('session')->getFlashBag()->add(
                'notice1',
                'Область "'.$area->getName().'" успешно добавлена!'
            );
            return $this->redirect($this->generateUrl('admin_admin_areaspage'));
        }

        return $this->render('AdminAdminBundle:Regions:add_area.html.twig', array(
            'form'              => $form->createView(),
            'for_moders'        => $for_moders
        ));
    }

    # Удаление Области

    public function deleteAreaAction($id)
    {
        $area = AreasQuery::create()->findOneById($id);
        if(!$area) {
            throw new NotFoundHttpException('Область отсутствует!');
        }

        $area->setDeleted(1);
        $area->save();

        $this->get('session')->getFlashBag()->add(
            'notice1',
            'Область "'.$area->getName().'" успешно удалена!'
        );

        return $this->redirect($this->generateUrl('admin_admin_areaspage'));
    }

}

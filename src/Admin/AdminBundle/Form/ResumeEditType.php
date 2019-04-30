<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsValues;
use Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\JobImages;
use Admin\AdminBundle\Model\JobVideos;
use Admin\AdminBundle\Controller\Image;
use Admin\AdminBundle\Model\JobImagesQuery;
use Admin\AdminBundle\Model\JobParams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ResumeEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id', 'text', array('label'  => '№ резюме:', 'read_only' => TRUE))
            ->add('create_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Дата создания:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('publish_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Дата публикации:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('publish_before_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Опубликовано до:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('name', 'text', array('label'  => 'Фамилия Имя Отчество:'))
            ->add('phone', 'text', array('label'  => 'Контактный телефон:'));

        # Выбор Категории объявления
        $categories = JobCategoriesQuery::create()->filterByParentId(0)->orderByParentId()->findByDeleted(0);
        $categories_array = array();
        foreach ($categories as $category) {
            $categories_array[$category->getName()]= array();
            $subcategories = JobCategoriesQuery::create()->filterByParentId($category->getId())->orderByName()->find();
            foreach ($subcategories as $subcategory) {
                $categories_array[$category->getName()][$subcategory->getId()]= $subcategory->getName();
            }
        }
        $builder
            ->add('category_id', 'choice', array(
                'choices'   => $categories_array,
                'label'  => 'Категория:',
                'attr' => array('class' => 'category_select')
            ));

        # Дополнительные поля Категории
        $category = JobCategoriesQuery::create()->findOneById($options['data']->getCategoryId());


        $category_fields = JobCategoriesFieldsQuery::create()
            ->filterByCategoryId(array(0, $category->getParentId(), $category->getId()))
            ->findByArray(array(
                    'deleted' => 0,
                    'enabled' => 1
                )
            );

        # Добавление полей
        if ($category_fields) {
            foreach($category_fields as $category_field) {

                # Типы полей: 1-текст; 2-список;
                if ($category_field->getType() == 2) {
                    if ($category_field->getParentFieldId() != 0) {
                        if (@$options['data']->{'params_'.$category_field->getParentFieldId()}) {
                            $parent_field_id = @$options['data']->{'params_'.$category_field->getParentFieldId()};

                            $choices = JobCategoriesFieldsValuesQuery::create()->findByArray(array(
                                'fieldId'       => $category_field->getId(),
                                'parentValueId' => $parent_field_id,
                                'deleted'       => FALSE
                            ));
                            $values = array();
                            foreach ($choices as $choice){
                                $values[$choice->getId()] = $choice->getName();
                            }
                            $category_field_childs_fields = @$category_field->getChildsFieldss();
                            $builder->add('params_'.$category_field->getId(), 'choice', array(
                                    'label'     => $category_field->getName(),
                                    'choices'   => $values,
                                    'attr'      => array('class' => @$category_field_childs_fields[0] ? 'jobchangeable' : ''),
                                    'help'      => $category_field->getHelper(),
                                    'required'  => FALSE
                                )
                            );
                        }
                    } else {
                        $choices = JobCategoriesFieldsValuesQuery::create()->findByArray(array(
                                'fieldId' => $category_field->getId(),
                                'deleted' => FALSE
                            )
                        );
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        $category_field_childs_fields = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'     => $category_field->getName(),
                                'choices'   => $values,
                                'attr'      => array('class' => @$category_field_childs_fields[0] ? 'jobchangeable' : ''),
                                'help'      => $category_field->getHelper(),
                                'required'  => FALSE
                            )
                        );
                    }
                } else {
                    $builder->add('params_'.$category_field->getId(), 'text', array(
                            'label'     => $category_field->getName(),
                            'help'      => $category_field->getHelper(),
                            'attr'      => array('class' => ($category_field->getType() == 4) ? 'address' : ($category_field->getType() == 5 ? 'coordinates' : '')),
                            'required'  => FALSE
                        )
                    );
                }
            }
        }

        # Выбор Региона
        $regions = RegionsQuery::create()->orderByName()->find();
        $regions_array = array();
        foreach ($regions as $region) {
            $regions_array[$region->getId()] = $region->getName();
        }

        $builder
            ->add('region_id', 'choice', array(
                'choices'   => $regions_array,
                'label'     => 'Регион'
            ));

        # Дополнительные поля Категорий
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
            $form = $event->getForm();
            $data = $event->getData();

            # Если добавили изображение или видео
            if (@$data['image']) {

                # Определяем тип загружаемого файла
                $file_type = $data['image']->getMimeType();

                # Для изображений
                switch($file_type) {
                    case 'image/png': $Filename = uniqid(); $ext ='.png'; break;
                    case 'image/jpeg': $Filename = uniqid(); $ext ='.jpg'; break;
                    case 'image/gif': $Filename = uniqid(); $ext ='.gif'; break;
                }
                if (@$Filename) {
                    $dir = 'images/jobs/images';
                    $data['image']->move($dir, $Filename.$ext);
                    $image = new JobImages();
                    $image->setJobId(0);
                    $image->setTempId($_SESSION['job_temp_id']);
                    $image->setPath($Filename.$ext);
                    $image->setThumb($Filename.'_s'.$ext);
                    $image->save();

                    # Создаем миниатюру высотой 100px
                    $image_new = new Image($dir.'/'.$Filename.$ext);
                    $image_new->fit_to_height(100);
                    $image_new->save($dir.'/'.$Filename.'_s'.$ext);

                    # Изменяем изображение до 900px по ширине и накладываем водяной знак /images/watermark.png
                    $image_new = new Image($dir.'/'.$Filename.$ext);
                    $image_original_info = $image_new->get_original_info();
                    if ( $image_original_info['width']>900 ) $image_new->fit_to_width(900);
                    $image_new->overlay('images/watermark.png', 'bottom right', .5, -5, -5);
                    $image_new->save($dir.'/'.$Filename.$ext);
                }

            }

            # Если удалили изображение
            if (@$data['imagedelete']) {
                $image = JobImagesQuery::create()->findOneById($data['imagedelete']);

                if ($image) {

                    $dir = 'images/jobs/images';
                    $Thumbname = $image->getThumb();
                    $Filename = $image->getPath();

                    # Удаляем миниатюру
                    $fs = new Filesystem();
                    try {
                        $fs->remove( $dir.'/'.$Thumbname );
                    } catch (IOExceptionInterface $e) {
                        echo "Ошибка удаления изображения ".$e->getPath();
                    }

                    # Удаляем изображение
                    $fs = new Filesystem();
                    try {
                        $fs->remove( $dir.'/'.$Filename );
                    } catch (IOExceptionInterface $e) {
                        echo "Ошибка удаления изображения ".$e->getPath();
                    }

                    $image->delete();

                }

            }

        });



        $builder
            ->add('description', 'textarea', array('label'  => 'Автобиография:'))
            ->add('image', 'file', array('label'  => 'Фотографии:', 'help' => 'Добавьте к своему резюме фотографии', 'required' => FALSE))
            ->add('imagedelete', 'hidden', array('required' => FALSE, 'mapped' => FALSE, 'data' => ''))
            ->add('price_from', 'text', array('label'  => 'Зарплата от:'))
            ->add('price_to', 'text', array('label'  => 'Зарплата до:'))
            ->add('enabled', 'checkbox', array('label'  => 'Включено:', 'required' => FALSE));

        # Кнопка Сохранить расположена в шаблоне Jobs\edit.html.twig

        //var_dump($builder);
        $builder
            ->getForm();

    }

    public function getName()
    {
        return 'jobs';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Advs',
        ));*/
    }

}

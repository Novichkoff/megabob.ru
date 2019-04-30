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

use \Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\JobImages;
use Admin\AdminBundle\Model\JobVideos;
use Admin\AdminBundle\Controller\Image;
use Admin\AdminBundle\Model\JobImagesQuery;
use Admin\AdminBundle\Model\JobVideosQuery;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ResumeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', 'text', array('label'  => 'Ваш логин:', 'mapped' => FALSE, 'data' => @$options['data']->username, 'help' => 'Укажите ваше логин'))
            ->add('email', 'text', array('label'  => 'E-mail:', 'mapped' => FALSE, 'data' => @$options['data']->email, 'help' => 'Укажите свой контактный email'))
            ->add('user_id', 'hidden', array('label'  => 'ID пользователя:'))
            ->add('phone', 'text', array('label'  => 'Контактный телефон:', 'help' => 'Укажите свой контактный телефон'));

        # Выбор Региона
        $regions = RegionsQuery::create()->orderByName()->find();
        $regions_array = array();
        $regions_array[0]='- Выберите город -';
        foreach ($regions as $region) {
            $regions_array[$region->getId()]= $region->getName();
        }

        $current_region = (@$_SESSION['region'] && $_SESSION['region']!='all') ? RegionsQuery::create()->findOneByName($_SESSION['region'])->getId() : 0;

        $builder
            ->add('region_id', 'choice', array(
                'choices'   => $regions_array,
                'label'     => 'Город:',
                'attr'      => array('class' => 'jobchangeable'),
                'data'      => $current_region
            ));
        $builder
            ->add('name', 'text', array('label'  => 'Фамилия Имя Отчество:'));

        # Выбор Категории объявления
        $categories = JobCategoriesQuery::create()
            ->joinWith('JobChilds Childs',Criteria::LEFT_JOIN)
            ->orderByParentId()
            ->findByDeleted(FALSE);
        $categories_array = array();
        $categories_array[0]='- Выберите рубрику -';
        foreach ($categories as $category) {
            $categories_array[$category->getName()]= array();
            foreach ($category->getJobChildss() as $subcategory) {
                $categories_array[$category->getName()][$subcategory->getId()]= $subcategory->getName();
            }
        }
        $builder
            ->add('category_id', 'choice', array(
                'choices'   => $categories_array,
                'label'     => 'Рубрика:',
                'attr'      => array('class' => 'category_select jobchangeable'),
                'help'      => 'Выберите наиболее подходящую для вас рубрику вакансий'
            ));

        # Добавление общих полей категорий
        $allcategory_fields = JobCategoriesFieldsQuery::create()
            ->joinWith('JobCategoriesFieldsValues',Criteria::LEFT_JOIN)
            ->joinWith('ChildsFields ChildsFields',Criteria::LEFT_JOIN)
            ->filterByCategoryId(0)
            ->orderByName()
            ->findByArray(array(
                    'deleted' => FALSE,
                    'enabled' => true
                )
            );

        if ($allcategory_fields) {
            foreach($allcategory_fields as $category_field) {

                # Типы полей: 1-текст; 2-список;
                if ($category_field->getType() == 2) {
                    if ($category_field->getParentFieldId() != 0) {
                        if (@$data['params_'.$category_field->getParentFieldId()]) {
                            $parent_field_id = $data['params_'.$category_field->getParentFieldId()];

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

        # Дополнительные поля Категорий
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
            $form = $event->getForm();
            $data = $event->getData();

            # Если изменили категорию
            if (@$data['category_id']) {
                $category = JobCategoriesQuery::create()
                    ->findOneById($data['category_id']);
                //var_dump($category);

                # Добавление полей категорий (подкатегорий)
                $category_fields = JobCategoriesFieldsQuery::create()
                    ->joinWith('JobCategoriesFieldsValues',Criteria::LEFT_JOIN)
                    ->joinWith('ChildsFields ChildsFields',Criteria::LEFT_JOIN)
                    ->filterByCategoryId(array(0,$category->getParentId(),$category->getId()))
                    ->orderByName()
                    ->findByArray(array(
                        'deleted' => FALSE,
                        'enabled' => true
                        )
                    );

                if ($category_fields) {
                    foreach($category_fields as $category_field) {

                        # Типы полей: 1-текст; 2-список;
                        if ($category_field->getType() == 2) {
                            if ($category_field->getParentFieldId() != 0) {
                                if (@$data['params_'.$category_field->getParentFieldId()]) {
                                    $parent_field_id = $data['params_'.$category_field->getParentFieldId()];
                                
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
                                    $form->add('params_'.$category_field->getId(), 'choice', array(
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
                                $form->add('params_'.$category_field->getId(), 'choice', array(
                                        'label'     => $category_field->getName(),
                                        'choices'   => $values,
                                        'attr'      => array('class' => @$category_field_childs_fields[0] ? 'jobchangeable' : ''),
                                        'help'      => $category_field->getHelper(),
                                        'required'  => FALSE
                                    )
                                );
                            }
                        } else {
                            $form->add('params_'.$category_field->getId(), 'text', array(
                                    'label'     => $category_field->getName(),
                                    'help'      => $category_field->getHelper(),
                                    'attr'      => array('class' => ($category_field->getType() == 4) ? 'address' : ($category_field->getType() == 5 ? 'coordinates' : '')),
                                    'required'  => FALSE
                                )
                            );
                        }
                    }
                }
            }

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
            ->add('description', 'textarea', array('label'  => 'Краткая автобиография:', 'help' => 'Заполните вашу автобиографию'))
            ->add('image', 'file', array('label'  => 'Фотографии:', 'help' => 'Добавьте к своему резюме фотографии', 'required' => FALSE))
            ->add('imagedelete', 'hidden', array('required' => FALSE, 'mapped' => FALSE, 'data' => ''))
            ->add('price_from', 'text', array('label'  => 'Зарплата от:', 'help' => 'Укажите нижнюю границу зарплаты'))
            ->add('price_to', 'text', array('label'  => 'Зарплата до:', 'help' => 'Укажите верхнюю границу зарплаты'))
            ->add('captcha', 'captcha', array('label'  => 'Проверочный код:'))
            ->add('enabled', 'checkbox', array('label'  => 'Я прочитал и согласен с правилами Claso','help' => 'Необходимо прочитать и согласиться с нашими правилами', 'required' => FALSE));


        $builder
            ->add('packet', 'hidden', array('mapped' => FALSE, 'required' => FALSE));

        # Кнопка Сохранить расположена в шаблоне Adv\add.html.twig

        $builder
            ->getForm();

    }

    public function getName()
    {
        return 'jobs';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

}

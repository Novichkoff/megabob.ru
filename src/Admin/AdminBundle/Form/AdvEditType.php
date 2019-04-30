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
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\AdvImages;
use Admin\AdminBundle\Model\AdvVideos;
use Admin\AdminBundle\Controller\Image;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvParams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class AdvEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id', 'text', array('label'  => '№ объявления:', 'read_only' => TRUE))			
            ->add('phone', 'text', array('label'  => 'Контактный телефон:','help' => 'Укажите свой контактный телефон. Указывайте только один номер!'))
            ->add('skype', 'text', array('label' => 'Skype:','required' => false,'help' => 'Укажите свой Skype. Если нет - оставьте пустым',))
            ->add('youtube', 'text', array('label' => 'Ссылка на видео:','required' => false, 'help' => 'Укажите ссылку на видео, например: http://www.youtube.com/watch?v=15CfYmHQc2s . Если нет - оставьте пустым',));
        
        if (@$options['data']->getUserId()) {
          $shops = ShopsQuery::create()->FilterByFosUserId($options['data']->getUserId())->find();
          if (@$shops) {
            $shops_array = array();            
            foreach ($shops as $shop) {
                $shops_array[$shop->getId()]= $shop->getName();
            }
            $builder
            ->add('shop_id', 'choice', array(
                'choices'   => $shops_array,
                'label'  => 'Компания:',
                'attr'  => array('class' => 'form-control selectpicker'),
                'help'  => 'Вы можете выбрать одну из своих компаний.',
                'required'  => FALSE
            ));
          }
        }

        # Выбор Категории объявления
        $categories = AdCategoriesQuery::create()->filterByParentId(NULL)->orderByParentId()->findByDeleted(0);
        $categories_array = array();
        foreach ($categories as $category) {
            $categories_array[$category->getName()]= array();
            $subcategories = AdCategoriesQuery::create()->filterByParentId($category->getId())->orderByName()->find();
            foreach ($subcategories as $subcategory) {
                $categories_array[$category->getName()][$subcategory->getId()]= $subcategory->getName();
            }
        }
        $builder
            ->add('category_id', 'choice', array(
                'choices'   => $categories_array,
                'label'  => 'Категория:',
                'attr' => array('class' => 'category_select form-control selectpicker check', 'data-live-search' => 'true'),
                'help' => 'Выберите наиболее подходящую для вашего объявления рубрику',
                'required'  => true
            ));

        # Дополнительные поля Категории
        $category = AdCategoriesQuery::create()->findOneById($options['data']->getCategoryId());
		
		$builder->add('name', 'text', array('label'  => $category->getNameTitle()?$category->getNameTitle().':':'Название объявления:', 'read_only'=>$category->getGenerator()?true:false, 'max_length' => 70,'help' => 'Напишите что вы предлагаете. Не пишите в этом поле цену, город, адрес сайта или номер телефона! Не более 70 символов.', 'required' => $category->getGenerator() ? true : false));

        $category_fields = AdCategoriesFieldsQuery::create()
            ->filterByCategoryId(array($category->getParentId(), $category->getId()))
            ->findByArray(array(
                    'deleted' => 0,
                    'enabled' => 1
                )
            );

        # Добавление полей
        if ($category_fields) {
            foreach($category_fields as $category_field) {

                # Типы полей: 1-текст; 2-список; 6-список зависимый от города; 7-список зависимый от региона;
                if ($category_field->getType() == 7) {
                    if (@$options['data']->getAreaId()) {
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'areaId'        => $options['data']->getAreaId(),
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control selectpicker'.($category_field->getRequired() ? ' check' : '') : 'form-control selectpicker'.($category_field->getRequired() ? ' check' : '')),
                                'disabled'      => $values ? false : true,
                                'required' 		=> $category_field->getRequired() ? true : false
                            ));
                        unset($values,$choices);
                    } else {
                        $values = array();
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control selectpicker'.($category_field->getRequired() ? ' check' : '') : 'form-control selectpicker'.($category_field->getRequired() ? ' check' : '')),
                                'disabled'      => $values ? false : true,
                                'required' 		=> $category_field->getRequired() ? true : false
                            ));
                        unset($values,$choices);
                    }
                } elseif ($category_field->getType() == 6) {
                    if (@$options['data']->getRegionId()) {
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                            'fieldId'       => $category_field->getId(),
                            'townId'        => $options['data']->getRegionId(),
                            'deleted'       => false
                        ));
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control selectpicker'.($category_field->getRequired() ? ' check' : '') : 'form-control selectpicker'.($category_field->getRequired() ? ' check' : '')),
                                'disabled'      => $values ? false : true,
                                'required' 		=> $category_field->getRequired() ? true : false
                            ));
                        unset($values,$choices);
                    } else {
                        $values = array();
                        $category_field_childs = @$category_field->getChildsFieldss();
                        $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'         => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                                'empty_value'   => 'выбрать',
                                'choices'       => $values,
                                'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control selectpicker'.($category_field->getRequired() ? ' check' : '') : 'form-control selectpicker'.($category_field->getRequired() ? ' check' : '')),
                                'disabled'      => $values ? false : true,
                                'required' 		=> $category_field->getRequired() ? true : false
                            ));
                        unset($values,$choices);
                    }					
                }
				elseif ($category_field->getType() == 9)
					{
					  $builder->add('params_' . $category_field->getId(), 'checkbox',
						  array(
						  'label' => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
						  'help' => $category_field->getHelper(),
						  'data' => $options['data']->{'params_'.$category_field->getId()}?true:false,
						  'required' => $category_field->getRequired() ? true : false)); 	  
					}
				elseif ($category_field->getType() == 2 || $category_field->getType() == 8) {
                    if ($category_field->getParentFieldId() != 0) {
                        if (@$options['data']->{'params_'.$category_field->getParentFieldId()}) {
                            $parent_field_id = @$options['data']->{'params_'.$category_field->getParentFieldId()};

                            $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                                'fieldId'       => $category_field->getId(),
                                'parentValueId' => $parent_field_id,
                                'deleted'       => FALSE
                            ));
                            $values = array();
                            foreach ($choices as $choice){
                                $values[$choice->getId()] = $choice->getName();
                            }
                            $category_field_childs_fields = @$category_field->getChildsFieldss();
                            if ($values) $builder->add('params_'.$category_field->getId(), 'choice', array(
                                    'label'         => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                                    'empty_value'   => 'выбрать',
                                    'choices'       => $values,
                                    'attr'          => array('class' => @$category_field_childs_fields[0] ? 'changeable form-control selectpicker'.($category_field->getRequired() ? ' check' : '') : 'form-control selectpicker'.($category_field->getRequired() ? ' check' : '')),
                                    'help'          => $category_field->getHelper(),
                                    'required' 		=> $category_field->getRequired() ? true : false
                                )
                            );
                        }
                    } else {
                        $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                                'fieldId' => $category_field->getId(),
                                'deleted' => FALSE
                            )
                        );
                        $values = array();
                        foreach ($choices as $choice){
                            $values[$choice->getId()] = $choice->getName();
                        }
                        asort($values);
                        $category_field_childs_fields = @$category_field->getChildsFieldss();
                        if ($values) $builder->add('params_'.$category_field->getId(), 'choice', array(
                                'label'     => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                                'empty_value'   => 'выбрать',
                                'choices'   => $values,
                                'attr'      => array('class' => @$category_field_childs_fields[0] ? 'changeable form-control selectpicker'.($category_field->getRequired() ? ' check' : '') : 'form-control selectpicker'.($category_field->getRequired() ? ' check' : '')),
                                'help'      => $category_field->getHelper(),
                                'required' 		=> $category_field->getRequired() ? true : false
                            )
                        );
                    }
                } else {
                    $builder->add('params_'.$category_field->getId(), 'text', array(
                            'label'     => $category_field->getName().($category_field->getPostfix()?' ('.$category_field->getPostfix().')':'').':',
                            'help'      => $category_field->getHelper(),
                            'attr'      => array('class' => ($category_field->getType() == 4) ? 'address' : ($category_field->getType() == 5 ? 'coordinates' : '')),
                            'required' 		=> $category_field->getRequired() ? true : false
                        )
                    );
                }
            }
        }

        # Выбор Региона
        $areas = AreasQuery::create()->orderByName()->find();
        $areas_array = array();
        foreach ($areas as $area) {
            $areas_array[$area->getId()] = $area->getName();
        }

        $builder
            ->add('area_id', 'choice', array(
                'choices'   => $areas_array,
                'label'     => 'Регион',
                'help' => 'Выберите регион подачи объявления',
                'attr' => array('class' => 'changeable form-control selectpicker check')
            ));

        # Выбор Города
        $regions_query = RegionsQuery::create();
        if (@$options['data']->getAreaId()) $regions_query->filterByAreaId($options['data']->getAreaId());
        $regions = $regions_query->orderByName()->find();        
        $regions_array = array();
        foreach ($regions as $region) {            
            $regions_array[$region->getId()] = $region->getName();
        }

        $builder
            ->add('region_id', 'choice', array(
                'choices'   => $regions_array,
                'label'     => 'Город',
                'help' => 'Выберите город подачи объявления',
                'attr' => array('class' => 'changeable form-control selectpicker check')
            ));

        # Дополнительные поля Категорий
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
            $form = $event->getForm();
            $data = $event->getData();

            # Если добавили изображение или видео
            if (@$data['image']) {

                # Определяем тип загружаемого файла
                $file_type = $data['image']->getMimeType();
				$size = getimagesize($data['image']);

                # Для изображений
                switch($file_type) {
                    case 'image/png': $Filename = uniqid(); $ext ='.png'; break;
                    case 'image/jpeg': $Filename = uniqid(); $ext ='.jpg'; break;
                    case 'image/gif': $Filename = uniqid(); $ext ='.gif'; break;
                }
                if (@$Filename) {
                    if ($size[0]>=300 && $size[0]>=200) {
						$dir = 'images/a/images';
						$data['image']->move($dir, $Filename.$ext);
						$image = new AdvImages();
						$image->setAdvId(NULL);
						$image->setTempId($_SESSION['adv_temp_id']);
						$image->setPath($Filename.$ext);
						$image->setThumb($Filename.'_s'.$ext);
						$image->setMediumThumb($Filename.'_m'.$ext);
						$image->save();
						
						$image_new = new Image($dir.'/'.$Filename.$ext);
						$image_new->save($dir.'/'.$Filename.$ext);
					}
                    unset($image_new);
                }                

            }

            # Если удалили изображение
            if (@$data['imagedelete']) {
                $image = AdvImagesQuery::create()->findOneById($data['imagedelete']);

                if ($image) {

                    $dir = 'images/a/images';
                    $Thumbname = $image->getThumb();
                    $MediumThumbname = $image->getMediumThumb();
                    $Filename = $image->getPath();

                    if ( $image->getTempId() != 0 ) {
                      # Удаляем миниатюру
                      if ($Thumbname) {
                        $fs = new Filesystem();
                        try {
                            $fs->remove( $dir.'/'.$Thumbname );
                        } catch (IOExceptionInterface $e) {
                            echo "Ошибка удаления изображения ".$e->getPath();
                        }
                      }
                      
                      # Удаляем среднюю миниатюру
                      if ($MediumThumbname) {
                        $fs = new Filesystem();
                        try {
                            $fs->remove( $dir.'/'.$MediumThumbname );
                        } catch (IOExceptionInterface $e) {
                            echo "Ошибка удаления изображения ".$e->getPath();
                        }  
                      }                        
                    }

                    # Удаляем изображение
                    if ($Filename) {
                      $fs = new Filesystem();
                      try {
                          $fs->remove( $dir.'/'.$Filename );
                      } catch (IOExceptionInterface $e) {
                          echo "Ошибка удаления изображения ".$e->getPath();
                      }
                    }

                    $image->delete();

                }

            }
            
            # Если повернули изображение
            if (@$data['imagerotate']) {
                $iimage = AdvImagesQuery::create()->findOneById($data['imagerotate']);

                if ($iimage) {

                    $dir = 'images/a/images';                    
                    $Filename = $iimage->getPath();
                    
                    $image_new = new Image($dir.'/'.$Filename);
                    $image_new->rotate(90,'#FFFFFF');
                    $image_new->save($dir.'/'.$Filename);
                    unset($image_new);

                }

            }            

        });



        $builder
            ->add('description', 'textarea', array('label'  => 'Полное описание (до 1000 симв.):','attr' => array('class' => 'check'),'help' => 'Подробно опишите ваш товар или услугу. Не указывайте в этом поле цену, email, адрес сайта или номер телефона!',))
            ->add('image', 'file', array('label'  => 'Изображения:', 'help' => 'Добавьте к своему объявлению изображения', 'mapped' => FALSE, 'required' => FALSE))
            ->add('imagedelete', 'hidden', array('required' => FALSE, 'mapped' => FALSE, 'data' => ''))
            ->add('imagerotate', 'hidden', array('required' => FALSE, 'mapped' => FALSE, 'data' => ''))
            ->add('coord', 'hidden', array('required' => FALSE, 'data' => ''))
            ->add('price', 'text', array('label'  => 'Цена (без пробелов и запятых):','attr' => array('data-inputmask' =>
              "'alias': 'numeric', 'digits': 0, 'digitsOptional': false"),'help' => 'Только в рублях! Вводите только цифры. Не используйте пробелы, запятые или другие символы.',))
            ->add('dogovor', 'checkbox', array('label'  => 'Договорная цена:', 'help' => 'Укажите если ваша цена договорная. Будет указана вместо цены.', 'required' => FALSE))
            ->add('torg', 'checkbox', array('label'  => 'Торг:', 'help' => 'Укажите согласны ли вы на торг','required' => FALSE))
            ->add('enabled', 'checkbox', array('label'  => 'Включено:', 'required' => FALSE))
            ->add('enabledd', 'hidden', array('label'  => 'Включено:', 'mapped' => FALSE, 'required' => FALSE, 'data' => FALSE))
			->add('site', 'text', array('label' => 'Сайт:','required' => false,'help' => 'Укажите адрес вашего сайта, если необходимо. Формат: http://site.ru . Если нет - оставьте пустым',));

        # Кнопка Сохранить расположена в шаблоне Advs\edit.html.twig

        //var_dump($builder);
        $builder
            ->getForm();

    }

    public function getName()
    {
        return 'advs';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Advs',
        ));*/
    }

}

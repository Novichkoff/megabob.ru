<?php

namespace Admin\AdminBundle\Form;

use \Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\AdvImages;
use Admin\AdminBundle\Model\AdvVideos;
use Admin\AdminBundle\Controller\Image;
use FOS\UserBundle\Propel\UserQuery;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class AdvTypeNew extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        
        $builder->add('user_type', 'choice', array(
            'choices' => array(
                '1' => 'Частное лицо',
                '2' => 'Компания'
            ),
            'multiple' => false,
            'expanded' => true,
            'required' => true,
            'data'     => '1',
            'label'    => ' '
        ));
        
        $builder
            ->add('username', 'text', array(
                'label'  => 'Ваше имя:', 
                'mapped' => FALSE, 
                'data' => @$options['data']->username, 
                'help' => 'Укажите ваше имя, чтобы покупатель назвал вас по имени', 
                'required'  => TRUE
                ))
            ->add('email', 'email', array(
                'label'          => 'E-mail:', 
                'mapped'      => FALSE,
                'data'          => @$options['data']->email,
                'attr'          => array('class' => 'changeable form-control','data-inputmask' => "'alias': 'email'"),
                'help'          => 'Укажите свой контактный email. Посетители сайта не увидят его.',
                'required'  => TRUE				
                ))
            ->add('user_id', 'hidden', array('label'  => 'ID пользователя:'))
            ->add('phone', 'text', array(
									'label'  => 'Контактный телефон:',
									'help' => 'Укажите свой контактный телефон. Указывайте только один номер!',
									'required'  => TRUE,
									'attr' => array('data-inputmask' => "'mask': '+7(999)999-9999'")
									));
            
        if (@$options['data']->email) {
          $user = UserQuery::create()->filterByEmail($options['data']->email)->findOne();
          if ($user) $shops = ShopsQuery::create()->FilterByFosUserId($user->getId())->find();
          if (@$shops) {
            $shops_array = array();            
            foreach ($shops as $shop) {
                $shops_array[$shop->getId()]= $shop->getName();
            }
            if ($shops_array)
            $builder
            ->add('shop_id', 'choice', array(
                'choices'   => $shops_array,
                'label'  => 'Компания:',
                'attr'  => array('class' => 'form-control'),
                'help'  => 'Вы можете выбрать одну из своих компаний.',
                'required'  => FALSE
            ));
          }
        }

        # Выбор Региона
        $areas = AreasQuery::create()->orderByName()->find();
        $areas_array = array();
        foreach ($areas as $area) {
            $areas_array[$area->getId()]= $area->getName();
        }

        $current_area = (@$_SESSION['area']) ? $_SESSION['area']->getId() : 0;
       
        $builder
            ->add('area_id', 'choice', array(
                'choices'       => $areas_array,
                'empty_value'   => 'выберите регион',
                'label'         => 'Регион:',
                'help'          => 'Выберите регион подачи объявления',
                'attr'          => array('class' => 'changeable form-control'),
                'data'          => $current_area,
                'required'      => TRUE
            ));

        if ($current_area) {
            $regions = RegionsQuery::create()->filterByAreaId($current_area)->orderByName()->find();
            $regions_array = array();
            foreach ($regions as $region) {
                $regions_array[$region->getId()]= $region->getName();
            }
           
            $current_region = (@$_SESSION['region'] && $_SESSION['region']!='all') ? $_SESSION['region']->getId() : 0;

            $builder->add('region_id', 'choice', array(
                'choices'       => $regions_array,
                'empty_value'   => 'выберите город',
                'label'         => 'Город:',
                'help'          => 'Выберите город подачи объявления',
                'attr'          => array('class' => 'changeable form-control'),
                'data'          => $current_region,
                'required'      => TRUE
            ));
        }        

        $builder
            ->add('name', 'text', array('label'  => 'Название объявления:', 'help' => 'Название объявления. Не пишите в названии цену, город или номер телефона.'));

        # Выбор Категории объявления
        $categories = AdCategoriesQuery::create()
            ->joinWith('AdChilds Childs',Criteria::LEFT_JOIN)
            ->orderByParentId()
            ->findByDeleted(FALSE);
        $categories_array = array();
        foreach ($categories as $category) {
            $categories_array[$category->getName()]= array();
            foreach ($category->getAdChildss() as $subcategory) {
                $categories_array[$category->getName()][$subcategory->getId()]= $subcategory->getName();
            }
        }
        $builder
            ->add('category_id', 'choice', array(
                'choices'       => $categories_array,
                'empty_value'   => 'выберите рубрику',
                'label'         => 'Рубрика:',
                'attr'          => array('class' => 'category_select changeable form-control'),
                'help'          => 'Выберите наиболее подходящую для вашего объявления рубрику',
                'required'      => TRUE
            ));

        # Дополнительные поля Категорий
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
            $form = $event->getForm();
            $data = $event->getData();

            # Если тип пользователя компания
            if (@$data['user_type'] == 2) {
                $form->add('company_name', 'text', array(
                        'label'  => 'Название компании:',
                        'help' => 'Укажите название компании, которую Вы представляете',
                        'required' => TRUE
                    )
                );
            }
            
            if (@$data['email'] && !$data['user_id']){
                $user = UserQuery::create()->filterByEmail($data['email'])->findOne();
                if($user) {                    
                    $form->add('password', 'text', array(
                        'label'  => 'Ваш пароль:',
                        'help' => 'Вы уже зарегистрированы, укажите ваш пароль',
                        'attr' => array('class' => 'form-control has-success'),
                        'required' => TRUE,
                        'mapped' => FALSE
                      )
                    );                    
                } 
            }

            
            # Выбор Города
            if (@$data['area_id']) {
                $regions_query = RegionsQuery::create();
                $regions_query->filterByAreaId($data['area_id']);
                $regions_query->orderByName();
                $regions = $regions_query->find();
                $regions_array = array();
                foreach ($regions as $region) {
                    $regions_array[$region->getId()]= $region->getName();
                }

                
                $current_region = (@$_SESSION['region'] && $_SESSION['region']!='all') ? $_SESSION['region']->getId() : 0;

                $form->add('region_id', 'choice', array(
                        'choices'       => $regions_array,
                        'empty_value'   => 'выберите город',
                        'label'         => 'Город:',
                        'help'          => 'Выберите город подачи объявления',
                        'attr'          => array('class' => 'changeable form-control'),
                        'data'          => $current_region,
                        'required'      => TRUE
                    ));
            }

            # Если изменили категорию
            if (@$data['category_id']) {
                $category = AdCategoriesQuery::create()
                    ->findOneById($data['category_id']);
                //var_dump($category);

                # Добавление полей категорий (подкатегорий)
                $category_fields = AdCategoriesFieldsQuery::create()
                    ->joinWith('AdCategoriesFieldsValues',Criteria::LEFT_JOIN)
                    ->joinWith('ChildsFields ChildsFields',Criteria::LEFT_JOIN)
                    ->filterByCategoryId(array($category->getParentId(),$category->getId()))
                    ->orderByCategoryId()
					->orderByName()
                    ->findByArray(array(
                        'deleted' => FALSE,
                        'enabled' => true
                        )
                    );

                if ($category_fields) {
                    foreach($category_fields as $category_field) {

                        # Типы полей: 1-текст; 2-список; 6-список зависимый от города; 7-список зависимый от региона;
                        if ($category_field->getType() == 7) {
                            if (@$data['area_id']) {
                                $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                                    'fieldId'       => $category_field->getId(),
                                    'areaId'        => $data['area_id'],
                                    'deleted'       => false
                                ));
                                $values = array();
                                foreach ($choices as $choice){
                                    $values[$choice->getId()] = $choice->getName();
                                }
                                asort($values);
                                $category_field_childs = @$category_field->getChildsFieldss();
                                $form->add('params_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName().':',
                                        'empty_value'   => 'выбрать',
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control' : 'form-control'),
                                        'disabled'      => $values ? false : true,
                                        'required'      => FALSE
                                    ));
                                unset($values,$choices);
                            } else {
                                $values = array();
                                $category_field_childs = @$category_field->getChildsFieldss();
                                $form->add('params_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName().':',
                                        'empty_value'   => 'выбрать',
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control' : 'form-control'),
                                        'disabled'      => $values ? false : true,
                                        'required'      => FALSE
                                    ));
                                unset($values,$choices);
                            }
                        } elseif ($category_field->getType() == 6) {
                            if (@$data['region_id']) {
                                $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                                    'fieldId'       => $category_field->getId(),
                                    'townId'        => $data['region_id'],
                                    'deleted'       => false
                                ));
                                $values = array();
                                foreach ($choices as $choice){
                                    $values[$choice->getId()] = $choice->getName();
                                }
                                asort($values);
                                $category_field_childs = @$category_field->getChildsFieldss();
                                $form->add('params_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName().':',
                                        'empty_value'   => 'выбрать',
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control' : 'form-control'),
                                        'disabled'      => $values ? false : true,
                                        'required'      => FALSE
                                    ));
                                unset($values,$choices);
                            } else {
                                $values = array();
                                $category_field_childs = @$category_field->getChildsFieldss();
                                $form->add('params_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName().':',
                                        'empty_value'   => 'выбрать',
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs[0] ? 'changeable form-control' : 'form-control'),
                                        'disabled'      => $values ? false : true,
                                        'required'      => FALSE
                                    ));
                                unset($values,$choices);
                            }
                        } elseif ($category_field->getType() == 2  || $category_field->getType() == 8) {
                            if ($category_field->getParentFieldId() != 0) {
                                if (@$data['params_'.$category_field->getParentFieldId()]) {
                                    $parent_field_id = $data['params_'.$category_field->getParentFieldId()];
                                
                                    $choices = AdCategoriesFieldsValuesQuery::create()->findByArray(array(
                                        'fieldId'       => $category_field->getId(),
                                        'parentValueId' => $parent_field_id,
                                        'deleted'       => FALSE
                                    ));
                                    $values = array();
                                    foreach ($choices as $choice){
                                        $values[$choice->getId()] = $choice->getName();
                                    }
                                    asort($values);
                                    $category_field_childs_fields = @$category_field->getChildsFieldss();
                                    $form->add('params_'.$category_field->getId(), 'choice', array(
                                            'label'         => $category_field->getName().':',
                                            'empty_value'   => 'выбрать',
                                            'choices'       => $values,
                                            'attr'          => array('class' => @$category_field_childs_fields[0] ? 'changeable form-control' : 'form-control'),
                                            'help'          => $category_field->getHelper(),
                                            'required'      => FALSE
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
                                $form->add('params_'.$category_field->getId(), 'choice', array(
                                        'label'         => $category_field->getName().':',
                                        'empty_value'   => 'выбрать',
                                        'choices'       => $values,
                                        'attr'          => array('class' => @$category_field_childs_fields[0] ? 'changeable form-control' : 'form-control'),
                                        'help'          => $category_field->getHelper(),
                                        'required'      => FALSE
                                    )
                                );
                            }
                        } else {
                            $form->add('params_'.$category_field->getId(), 'text', array(
                                    'label'     => $category_field->getName().':',
                                    'help'      => $category_field->getHelper(),
                                    'attr'      => array(
										'class' => ($category_field->getType() == 4) ? 'address' : ($category_field->getType() == 5 ? 'coordinates' : ''),
										'data-inputmask' => $category_field->getMask()?:''
									),
                                    'required'  => FALSE
                                )
                            );
                        }
                    }
                }
            }

            # Если добавили изображение
            if (@$data['image']) {

                # Определяем тип загружаемого файла
                $file_type = $data['image']->getMimeType();
				$size = getimagesize($data['image']);				
				if ($size[0]>=300 && $size[0]>=200) {

					# Для изображений
					switch($file_type) {
						case 'image/png': $Filename = uniqid(); $ext ='.png'; break;
						case 'image/jpeg': $Filename = uniqid(); $ext ='.jpg'; break;
						case 'image/gif': $Filename = uniqid(); $ext ='.gif'; break;
					}
					if (@$Filename) {
						$dir = 'images/advs/images';
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
						unset($image_new);
					}
				}

            }

            # Если удалили изображение
            if (@$data['imagedelete']) {
                $image = AdvImagesQuery::create()->findOneById($data['imagedelete']);

                if ($image) {

                    $dir = 'images/advs/images';                    
                    $Filename = $image->getPath();                    

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

                    $dir = 'images/advs/images';                    
                    $Filename = $iimage->getPath();                    
                    
                    # Поворачиваем изображение
                    $image_new = new Image($dir.'/'.$Filename);
                    $image_new->rotate(90,'#FFFFFF');
                    $image_new->save($dir.'/'.$Filename);
                    unset($image_new);

                }

            }            

        });

        $builder
            ->add('description', 'textarea', array('label'  => 'Описание объявления (до 1000 симв.):', 'help' => 'Полный текст объявления. Опишите товар, объект или услугу подробнее. Не указывайте цену или номер телефона.', 'required' => TRUE))
            ->add('image', 'file', array('label'  => 'Изображения:', 'help' => 'Добавьте к своему объявлению изображения. Размер изображения должен быть не менее 300х200', 'required' => FALSE))
            ->add('imagedelete', 'hidden', array('required' => FALSE, 'mapped' => FALSE, 'data' => ''))
            ->add('imagerotate', 'hidden', array('required' => FALSE, 'mapped' => FALSE, 'data' => ''))
            ->add('coord', 'hidden', array('required' => FALSE, 'data' => ''))            
            ->add('price', 'number', array('label'  => 'Цена:', 'help' => 'Укажите цену. Вводите только цифры. Не используйте пробелы, запятые или другие символы.', 'required' => TRUE, 'attr'=> array('data-inputmask' => "'alias': 'numeric', 'digits': 0, 'digitsOptional': false"), 'data' => '0'))
            ->add('dogovor', 'checkbox', array('label'  => 'Договорная цена:', 'help' => 'Укажите если ваша цена договорная. Будет указана вместо цены.', 'required' => FALSE))
            ->add('torg', 'checkbox', array('label'  => 'Торг:', 'help' => 'Укажите согласны ли вы на торг', 'required' => FALSE))
            ->add('captcha', 'captcha', array('label'  => 'Проверочный код:', 'required' => TRUE, 'help' => 'Введите проверочный код с картинки справа (5 цифр)'))
            ->add('enabled', 'checkbox', array('label'  => 'Я прочитал и согласен с правилами Claso', 'help' => 'Необходимо прочитать и согласиться с нашими правилами', 'required' => TRUE));


        $builder
            ->add('packet', 'hidden', array('mapped' => FALSE, 'required' => FALSE));

        # Кнопка Сохранить расположена в шаблоне Adv\add.html.twig

        $builder
            ->getForm();           
           

    }

    public function getName()
    {
        return 'advs';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Model\Advs',
        ));
    }

}

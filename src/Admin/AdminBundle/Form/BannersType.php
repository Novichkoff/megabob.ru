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

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\HttpFoundation\File\File;

use Admin\AdminBundle\Model\AdCategoriesQuery;

use Admin\AdminBundle\Model\RegionsQuery;



class BannersType extends AbstractType

{



    public function buildForm(FormBuilderInterface $builder, array $options)

    {



        $regions = RegionsQuery::create()->orderByName()->find();

        $regions_array = array();

        $regions_array[0]='Любой регион';

        foreach ($regions as $region) {

            $regions_array[$region->getId()] = $region->getName();

        }

		

        $categories = AdCategoriesQuery::create()->filterByParentId(NULL)->orderByParentId()->findByDeleted(0);

        $categories_array = array();

        $categories_array[0]='Любая рубрика';

        foreach ($categories as $category) {

            $categories_array[$category->getName()]= array();

            $subcategories = AdCategoriesQuery::create()->filterByParentId($category->getId())->orderByName()->find();

            foreach ($subcategories as $subcategory) {

                $categories_array[$category->getName()][$subcategory->getId()]= $subcategory->getName();

            }            

        }

		

        $builder

            ->add('enabled', 'checkbox', array('label'  => 'Активно:', 'required' => FALSE))
            ->add('mobile', 'checkbox', array('label'  => 'Для мобильных:', 'required' => FALSE))
            ->add('full_size', 'checkbox', array('label'  => 'Для полного экрана:', 'required' => FALSE))
            ->add('last_publish', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Последний показ:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('publish_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Дата публикации:',
                'required'  => FALSE,
                'read_only' => TRUE))
            ->add('publish_before_date', 'datetime', array(
                'widget'    => 'single_text',
                'label'     => 'Публикация до:',
                'required'  => TRUE))
            ->add('cnt', 'text', array('label'  => 'Осталось показов:', 'required' => TRUE))
            ->add('name', 'text', array('label'  => 'Название:'))
            ->add('client', 'text', array('label'  => 'Клиент (телефон):'))
            ->add('region_id', 'choice', array(
                      'choices'   => $regions_array,
                      'label'     => 'Регион:'
                  ))
            ->add('category_id', 'choice', array(
                      'choices'   => $categories_array,
                      'label'  => 'Категория:'
                  ))
            ->add('banner_zone_id', 'choice', array(
                'choices'   => array( 0 => '- Выберите зону -', 1 => 'Самый верхний', 2 => 'Под поиском', 3 => 'Среди объявлений', 4 => 'В правой колонке', 5 => 'Самый нижний', 6 => 'В объявлении', 7 => 'Вместо картинки'),
                'label'     => 'Баннерная зона:',
                'required'  => TRUE
            ))
            ->add('width', 'text', array('label'  => 'Ширина баннера(px):', 'required' => FALSE))
            ->add('code', 'textarea', array('label'  => 'Код баннера:', 'required' => TRUE))
            ->add('picture', 'file', array('label'  => 'Загрузить изображение', 'required' => false))
            ->add('save', 'submit', array('label'  => 'Сохранить'))
            ->getForm();



    }



    public function getName()

    {

        return 'banners';

    }



    public function setDefaultOptions(OptionsResolverInterface $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => 'Admin\AdminBundle\Model\Banners',

        ));

    }



}


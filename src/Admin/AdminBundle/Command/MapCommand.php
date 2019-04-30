<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use FOS\UserBundle\Propel\UserQuery;

class MapCommand extends ContainerAwareCommand
{

  # Cron-задание получения координат от Яндекса у объявлений с адресом или координатами
  protected function configure()
  {
    $this->setName('cron:map')->setDescription('Map Task');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $categories_usemap = AdCategoriesQuery::create()->
      filterByUsemap(true)->filterByDeleted(false)->find();
    
    
    foreach ($categories_usemap as $category_usemap)
    {      
      //var_dump($category_usemap->getName());
      $advs = AdvsQuery::create()->filterByCategoryId($category_usemap->getId())->filterByDeleted(false)->filterByCoord(NULL)->find();
      $field_address = AdCategoriesFieldsQuery::create()->filterByCategoryId($category_usemap->
        getId())->filterByType(4)->findOne();
      $field_coord = AdCategoriesFieldsQuery::create()->filterByCategoryId($category_usemap->
        getId())->filterByType(5)->findOne();      
      foreach ($advs as $adv)
      {		
		  
		  $adv_param_a = $adv_param_c = NULL;
		  $area = AreasQuery::create()->filterById($adv->getAreaId())->findOne();
		  $region = RegionsQuery::create()->filterById($adv->getRegionId())->findOne();
		  if (@$field_address && @$field_address->getId()) {
			  $adv_param_a = AdvParamsQuery::create()
				->filterByFieldId($field_address->getId())
				->filterByAdvId($adv->getId())
				->findOne();
		  }
			  
		  if (@$field_coord && @$field_coord->getId()) {			  
			  $adv_param_c = AdvParamsQuery::create()
				->filterByAdvId($adv->getId())
				->filterByFieldId($field_coord->getId())
				->findOne();
		  }
			
		  if (@$adv_param_a && @$adv_param_a->getTextValue())
		  {			
			$full_address = $area . ', ' . $region . ', ' . $adv_param_a->getTextValue();
			$output->writeln($full_address);
			$coordinates = $this->getCoordinates($full_address);
			$output->writeln($coordinates);
			$adv->setCoord($coordinates);
			$adv->save();
		  }
		  if (@$adv_param_c && @$adv_param_c->getTextValue()) {
			  $output->writeln($adv_param_c->getTextValue());
			  $adv->setCoord($adv_param_c->getTextValue());
			  $adv->save();
			}         
        
      }
    }    

    $output->writeln('ok');
  }

  function getCoordinates($address)
  {    
    $urlXml = "http://geocode-maps.yandex.ru/1.x/?geocode=" . urlencode($address);
    $result = @simplexml_load_file($urlXml);
    if ($result)
    {
      $coord = $result->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
      $array_coord = explode(' ', $coord);
      $str_coord = $array_coord[1] . ',' . $array_coord[0];
      return $str_coord;
    }
    return false;
  }
}

<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\Advs;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Zend\Stdlib\DateTime;

class Auto implements ItemInterface
{
  public function __construct($adv)
  {
    $this->adv = $adv;
  }

  public function getFeedItemTitle()
  {
    return $this->adv->getName();
  }

  public function getFeedItemDescription()
  {
    return $this->adv->getDescription();
  }

  public function getFeedItemLink()
  {
    $url = "https://claso.ru/russia/" . $this->adv->getId();
    return $url;
  }

  public function getFeedItemPubDate()
  {    
	return $this->adv->getPublishDate();
  }
  
  public function getFeedItemPubBeforeDate()
  {    
	return $this->adv->getPublishBeforeDate();
  }

  public function getFeedItemMark()
  {
    return @$this->adv->params[22] ? $this->adv->params[22] : 'na';
  }

  public function getFeedItemModel()
  {
    return @$this->adv->params[23] ? $this->adv->params[23] : 'na';
  }

  public function getFeedItemYear()
  {
    return @$this->adv->params[16] ? $this->adv->params[16] : 'na';
  }

  public function getFeedItemRun()
  {
    return @$this->adv->params[20] ? $this->adv->params[20] : 10000;
  }

  public function getFeedItemRunMetric()
  {
    return 'км';
  }

  public function getFeedItemSteeringWheel()
  {
    return @$this->adv->params[18] ? $this->adv->params[18] : 'левый';
  }

  public function getFeedItemStock()
  {
    return 'в наличии';
  }
  
  public function getFeedItemState()
  {
    return @$this->adv->params[27] ? $this->adv->params[27] : 'среднее';
  }

  public function getFeedItemDisplacement()
  {
    return @$this->adv->params[19] ? $this->adv->params[19] : 1500;
  }

  public function getFeedItemCurrencyType()
  {
    return 'RUR';
  }

  public function getFeedItemPrice()
  {
    return $this->adv->getPrice();
  }

  public function getFeedItemSellerPhone()
  {
    return $this->adv->getPhone();
  }

  public function getFeedItemSellerCity()
  {
    return $this->adv->getRegions()->getName();
  }
  
  public function getFeedItemColor()
  {
    return @$this->adv->params[25] ? $this->adv->params[25] : NULL;
  }
  
  public function getFeedItemImage()
  {
    $images = array();
    foreach($this->adv->getAdvImagess()->getData() as $image) {
      $images[] = 'https://claso.ru/images/a/images/'.$image->getPath();  
    }
    if (@$images) return $images;	
  }

}

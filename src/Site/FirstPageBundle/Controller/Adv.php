<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\Advs;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Zend\Stdlib\DateTime;

class Adv implements ItemInterface
{
    public function __construct($adv)
    {
        $this->adv = $adv;
    }
    
    public function getFeedItemTitle() {
      return $this->adv->getName();
    }

    public function getFeedItemDescription() {
      return $this->adv->getDescription().' <br><a href="https://claso.ru/russia/'.$this->adv->getId().'">Перейти к объявлению</a>';
    }
    
    public function getFeedItemLink() {      
      $url = "https://claso.ru/russia/".$this->adv->getId();
      return $url;
    }
         
    public function getFeedItemPubDate() {      
      return $this->adv->getPublishDate();
    }
	
	public function getFeedItemImage() {
		$images = array();
		foreach($this->adv->getAdvImagess()->getData() as $image) {
			$images[] = 'https://claso.ru/images/a/images/'.$image->getPath();  
		}
		if (@$images) return $images;	
	  }

}

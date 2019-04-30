<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\Advs;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Zend\Stdlib\DateTime;

class AdvVk implements ItemInterface
{
    public function __construct($adv)
    {
        $this->adv = $adv;
    }
    
    public function getFeedItemTitle() {
      return $this->adv->getName();
    }

    public function getFeedItemDescription() {
      return $this->adv->getDescription();
    }
    
    public function getFeedItemLink() {      
      $url = $this->adv->url;
      return $url;
    }
         
    public function getFeedItemPubDate() {      
      return $this->adv->getPublishDate();
    }
	
	public function getFeedItemEnclosure() {      
      return '';
    }
	
	public function getFeedItemImage() {		
		if ($this->adv->getImage()) {			
			$image = $this->adv->domain.'images/a/images/'.$this->adv->getImage()->getPath();  
		}
		if (@$image) return $image;	
	  }

}

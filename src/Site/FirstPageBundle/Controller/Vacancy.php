<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\Advs;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Zend\Stdlib\DateTime;

class Vacancy implements ItemInterface
{
    public function __construct($adv)
    {
        $this->adv = $adv;
    }
    
    public function getFeedItemId() {       
      return $this->adv->getId();
    }
	
	public function getFeedItemTitle() {       
      return $this->adv->getName();
    }

    public function getFeedItemDescription() {
      return $this->adv->getDescription();
    }
    
    public function getFeedItemLink() {      
      $url = "https://claso.ru/russia/".$this->adv->getId();
      return $url;
    }
         
    public function getFeedItemCreateDate() {      
      return $this->adv->getCreateDate();
    }
	
	public function getFeedItemPubDate() {      
      return $this->adv->getPublishDate();
    }
	
	public function getFeedItemEmployment() {
      return @$this->adv->params[208]?$this->adv->params[208]:NULL;
    }
    
    public function getFeedItemYear() {
      return @$this->adv->params[16]?$this->adv->params[16]:'';
    }
    
    public function getFeedItemStock() {
      return 'в наличии';
    }
    
    public function getFeedItemDisplacement() {
      return @$this->adv->params[19]?$this->adv->params[19]:1500;
    }
	
	public function getFeedItemArea() {
      if ($this->adv->getCategoryId() == 29) return @$this->adv->params[66]?$this->adv->params[66]:NULL;
	  if ($this->adv->getCategoryId() == 125) return @$this->adv->params[153]?$this->adv->params[153]:NULL;
    }
	
	public function getFeedItemLivingSpace() {
      if ($this->adv->getCategoryId() == 29) return @$this->adv->params[163]?$this->adv->params[163]:NULL;
	  if ($this->adv->getCategoryId() == 125) return NULL;
    }
	
	public function getFeedItemKitchenSpace() {
      if ($this->adv->getCategoryId() == 29) return @$this->adv->params[164]?$this->adv->params[164]:NULL;
	  if ($this->adv->getCategoryId() == 125) return NULL;	  
    }
	
	public function getFeedItemUnit() {
      return 'кв.м';
    }
	
	public function getFeedItemRooms() {
      return @$this->adv->params[64]?($this->adv->params[64]=='Студия'?1:$this->adv->params[64]):1;
    }
    
    public function getFeedItemCurrency() {
      return 'RUR';
    }
	
	public function getFeedItemIndustry() {
       return $this->adv->params[168];
    }
	
	public function getFeedItemSpecialization() {
       return $this->adv->params[168];
    }	
    
    public function getFeedItemPrice() {
      return $this->adv->getPrice()?'от '.$this->adv->getPrice():NULL;
    }
	
	public function getFeedItemCompany() {
      return $this->adv->getCompanyName()?$this->adv->getCompanyName():NULL;
    }
	
	public function getFeedItemCompanyDescription() {
      return "";
    }
	
	public function getFeedItemTown() {
      return $this->adv->getRegions()->getName();
    }
	
	public function getFeedItemAddress() {
      return 'Россия, '.$this->adv->getRegions()->getName().(@$this->adv->params[182]?', '.$this->adv->params[182]:'');	  
    }
	
	public function getFeedItemMetro() {
      return @$this->adv->params[183]?$this->adv->params[183]:NULL;	  
    }
    
    public function getFeedItemSellerPhone() {
      return $this->adv->getPhone();
    }
}

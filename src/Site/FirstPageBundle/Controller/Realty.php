<?php

namespace Site\FirstPageBundle\Controller;

use Admin\AdminBundle\Model\Advs;
use Eko\FeedBundle\Item\Writer\ItemInterface;
use Zend\Stdlib\DateTime;

class Realty implements ItemInterface
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
         
    public function getFeedItemPubDate() {      
      return $this->adv->getPublishDate();
    }
    
    public function getFeedItemType() {
      if (@$this->adv->params[88]) {
		  if ($this->adv->params[88] == 'Продам') return 'продажа';
		  if ($this->adv->params[88] == 'Сдам') return 'аренда';
	  }
	  return '';
    }
	
	public function getFeedItemPropertyType() {
      return 'жилая';
    }
	
	public function getFeedItemCategory() {
      if ($this->adv->getCategoryId() == 29) return 'квартира';
	  if ($this->adv->getCategoryId() == 125) return 'комната';
    }
	
	public function getFeedItemLocation() {
      return 'квартира';
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
	
	public function getFeedItemUnitArea() {      
	  if ($this->adv->getCategoryId() == 29) {
		if (@$this->adv->params[66]) return 'кв.м';
	  } elseif ($this->adv->getCategoryId() == 125 && @$this->adv->params[153]) return 'кв.м';
	  return NULL;	  
    }
	
	public function getFeedItemUnitLiving() {      
	  if ($this->adv->getCategoryId() == 29) {
		if (@$this->adv->params[163]) return 'кв.м';
	  }
	  return NULL;	  
    }
	public function getFeedItemUnitKitchen() {      
	  if ($this->adv->getCategoryId() == 29) {
		if (@$this->adv->params[164]) return 'кв.м';
	  }
	  return NULL;	  
    }
	
	public function getFeedItemRooms() {
      return @$this->adv->params[64]?($this->adv->params[64]=='Студия'?1:$this->adv->params[64]):1;
    }
    
    public function getFeedItemCurrencyType() {
      return 'RUR';
    }
	
	public function getFeedItemPeriodType() {
		if ($this->adv->params[88] == 'Сдам') {
			if ($this->adv->params[195] == 'Сутки') {
				return 'сутки'; 
			} else return 'месяц';			
		} else return NULL;
    }
	
    
    public function getFeedItemPrice() {
      return $this->adv->getPrice();
    }
	
	public function getFeedItemCountry() {
      return 'Россия';
    }
	
	public function getFeedItemTown() {
      return $this->adv->getRegions()->getName();
    }
	
	public function getFeedItemAddress() {
    if ($this->adv->getCategoryId() == 29) return @$this->adv->params[31]?$this->adv->params[31]:NULL;
    if ($this->adv->getCategoryId() == 125) return @$this->adv->params[152]?$this->adv->params[152]:NULL;
  
  }
  
  public function getFeedItemSellerPhone() {
    return $this->adv->getPhone();
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

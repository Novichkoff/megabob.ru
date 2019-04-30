<?php

namespace Admin\AdminBundle\Model;

use Admin\AdminBundle\Model\om\BaseAdvParams;
use Admin\AdminBundle\Model\om\BaseAdvs;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvImages;

class Advs extends BaseAdvs
{
    public $email;

    public function __construct()
    {

        for ($i = 1; $i <= 300; $i++) {
            $this->{'params_'.$i} = NULL;
        }
        $this->packet = NULL;
		$this->image = NULL;		
    }
    
    public function getEmail()
    {

        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getParams()
    {
        for ($i = 1; $i <= 300; $i++) {
            return $this->{'params_'.$i};
        }    
    }
	public function getPacket()
    {
        return $this->packet;    
    }
    public function getImage()
    {
        $images = $this->getAdvImagess();		
		return count($images)? $images[0] : NULL;
    }

}

<?php

namespace Admin\AdminBundle\Model;

use Admin\AdminBundle\Model\om\BaseAdvsQuery;

class AdvsQuery extends BaseAdvsQuery
{
    public function filterByText($text) {        
        return $this->where('Name like "%'.$text.'%"')->orWhere('Description like "%'.$text.'%"');
    }
}

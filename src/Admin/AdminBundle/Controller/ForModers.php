<?php

namespace Admin\AdminBundle\Controller;

use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvComplaineQuery;
use Admin\AdminBundle\Model\ShopsQuery;

class ForModers
{
    public function build()
    {
        # Объявления для модератора
        $for_moders['advs'] = AdvsQuery::create()
            ->findByArray( array(
                    'enabled' => true,
                    'deleted' => false,
                    'moderApproved' => false
                )
            )
            ->count();

        # Жалобы для модератора
        $for_moders['complaines'] = AdvComplaineQuery::create()
            ->find()
            ->count();        
            
        # Магазины для модератора
        $for_moders['shops'] = ShopsQuery::create()
            ->findByArray( array(
                    'enabled' => false
                )
            )
            ->count();

        return $for_moders;
    }
}
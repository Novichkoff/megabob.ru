<?php

namespace Admin\AdminBundle\Model;

use Admin\AdminBundle\Model\om\BaseShops;
use \Criteria;

class Shops extends BaseShops
{
  
  public function getAdvss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvssPartial && !$this->isNew();
        if (null === $this->collAdvss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvss) {
                // return empty collection
                $this->initAdvss();
            } else {
                $collAdvss = AdvsQuery::create(null, $criteria)
                    ->filterByShops($this)
                    ->join('AdvImages',Criteria::LEFT_JOIN)
                    ->withColumn('AdvImages.Id', 'photo')
                    ->withColumn('AdvImages.Thumb', 'thumb')
                    ->groupBy('Id')
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvssPartial && count($collAdvss)) {
                      $this->initAdvss(false);

                      foreach ($collAdvss as $obj) {
                        if (false == $this->collAdvss->contains($obj)) {
                          $this->collAdvss->append($obj);
                        }
                      }

                      $this->collAdvssPartial = true;
                    }

                    $collAdvss->getInternalIterator()->rewind();

                    return $collAdvss;
                }

                if ($partial && $this->collAdvss) {
                    foreach ($this->collAdvss as $obj) {
                        if ($obj->isNew()) {
                            $collAdvss[] = $obj;
                        }
                    }
                }

                $this->collAdvss = $collAdvss;
                $this->collAdvssPartial = false;
            }
        }

        return $this->collAdvss;
    }
    
}

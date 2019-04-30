<?php

namespace Admin\AdminBundle\Model;

use Admin\AdminBundle\Model\om\BaseJobs;

class Jobs extends BaseJobs
{
    public function __construct()
    {

        $category_fields = JobCategoriesFieldsQuery::create()
            ->findByArray(array(
                    'deleted' => false,
                    'enabled' => true
                )
            );

        foreach ($category_fields as $category_field) {
            $this->{'params_'.$category_field->getId()} = '';
        }

        $this->image = '';
    }

    public function getParams()
    {
        $category_fields = JobCategoriesFieldsQuery::create()
            ->findByArray(array(
                    'deleted' => false,
                    'enabled' => true
                )
            );

        foreach ($category_fields as $category_field) {
            return $this->{'params_'.$category_field->getId()};
        }
    }

    public function getImage()
    {
        return $this->image;
    }
}

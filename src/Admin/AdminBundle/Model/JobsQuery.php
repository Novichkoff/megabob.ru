<?php

namespace Admin\AdminBundle\Model;

use Admin\AdminBundle\Model\om\BaseJobsQuery;

class JobsQuery extends BaseJobsQuery
{
    public function filterByText($text) {
        $pattern = '%' . $text . '%';
        return $this->where('Jobs.Name like ?', $pattern)
            ->orWhere('Jobs.Description like ?', $pattern);
    }
}

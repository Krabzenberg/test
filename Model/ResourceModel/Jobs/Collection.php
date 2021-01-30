<?php

namespace Extensa\Careers\Model\ResourceModel\Jobs;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Extensa\Careers\Model\Jobs::class,
            \Extensa\Careers\Model\ResourceModel\Jobs::class
        );
    }
}

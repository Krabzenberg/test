<?php

namespace Extensa\Careers\Model\ResourceModel\Categories;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Extensa\Careers\Model\Categories::class,
            \Extensa\Careers\Model\ResourceModel\Categories::class
        );
    }
}

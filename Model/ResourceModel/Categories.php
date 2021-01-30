<?php

namespace Extensa\Careers\Model\ResourceModel;

class Categories extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('extensa_careers_categories', 'category_id');
    }
}

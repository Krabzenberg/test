<?php

namespace Extensa\Careers\Model;

use Magento\Framework\Model\AbstractModel;

class Jobs extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Extensa\Careers\Model\ResourceModel\Jobs::class);
    }
}

<?php

namespace Extensa\Careers\Model\ResourceModel;

class Jobs extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('extensa_careers_jobs', 'job_id');
    }
}

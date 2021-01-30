<?php

namespace Extensa\Careers\Controller\Adminhtml\Jobs;

use Magento\Backend\App\Action;

class Add extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}

<?php

namespace Extensa\Careers\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class Job extends Template
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        Registry $registry
    )
    {
        parent::__construct($context);
        $this->_coreRegistry = $registry;
    }

    public function getJob()
    {
        return $this->_coreRegistry->registry('current_job');
    }

    public function getFormAction()
    {
        return $this->getUrl('careers/career/newcandidate', ['_secure' => true]);
    }
}

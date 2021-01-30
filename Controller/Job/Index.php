<?php

namespace Extensa\Careers\Controller\Job;

use Extensa\Careers\Model\Jobs;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Magento\Backend\Model\Session;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $jobsModel;
    protected $session;
    protected $_pageFactory;
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Registry $registry,
        Jobs $jobsModel,
        Session $session
    )
    {
        parent::__construct($context);

        $this->jobsModel = $jobsModel;
        $this->session = $session;
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $registry;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $job = $this->jobsModel;

        if ($id) {
            $job->load($id);
        }

        $this->_coreRegistry->register('current_job', $job);

        return $this->_pageFactory->create();
    }
}

<?php

namespace Extensa\Careers\Controller\Adminhtml\Jobs;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_resultPageFactory;
    protected $_resultPage;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->_setPageData();

        return $this->getResultPage();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::jobs');
    }

    public function getResultPage()
    {
        if (($this->_resultPage) === null) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }

        return $this->_resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('Extensa_Careers::jobs');
        $resultPage->getConfig()->getTitle()->prepend((__('Jobs')));
        $resultPage->addBreadcrumb(__('Careers'), __('Careers'));
        $resultPage->addBreadcrumb(__('Jobs'), __('Jobs'));

        return $this;
    }
}

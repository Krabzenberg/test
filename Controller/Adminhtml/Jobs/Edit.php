<?php

namespace Extensa\Careers\Controller\Adminhtml\Jobs;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Jobs;
use Magento\Backend\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $jobsModel;
    protected $session;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Jobs $jobsModel,
        Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->session = $session;
        $this->jobsModel = $jobsModel;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::jobs');
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Extensa_Careers::jobs')
            ->addBreadcrumb(__('Career'), __('Career'))
            ->addBreadcrumb(__('Jobs'), __('Jobs'))
            ->addBreadcrumb(__('Edit'), __('Edit'));

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->jobsModel;

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->session->getFormData();

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('job_item', $model);
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Career'));
        $resultPage->getConfig()->getTitle()->prepend(__('Jobs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Edit'));

        return $resultPage;
    }
}

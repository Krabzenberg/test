<?php

namespace Extensa\Careers\Controller\Adminhtml\Jobs;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Jobs;

class Delete extends Action
{
    protected $jobsModel;

    public function __construct(
        Action\Context $context,
        Jobs $jobsModel
    ) {
        parent::__construct($context);
        $this->jobsModel = $jobsModel;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::jobs');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->jobsModel;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Position deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Position does not exist'));

        return $resultRedirect->setPath('*/*/');
    }
}

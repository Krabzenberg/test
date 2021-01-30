<?php

namespace Extensa\Careers\Controller\Adminhtml\Categories;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Categories;

class Delete extends Action
{
    protected $categoriesModel;

    public function __construct(
        Action\Context $context,
        Categories $categoriesModel
    ) {
        parent::__construct($context);
        $this->categoriesModel = $categoriesModel;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::categories');
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
                $model = $this->categoriesModel;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Card deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Card does not exist'));

        return $resultRedirect->setPath('*/*/');
    }
}

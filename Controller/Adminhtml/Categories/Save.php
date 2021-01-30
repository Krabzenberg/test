<?php

namespace Extensa\Careers\Controller\Adminhtml\Categories;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Extensa\Careers\Model\Categories;
use Magento\Backend\Model\Session;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action
{
    protected $session;
    protected $categoriesModel;

    public function __construct(
        Context $context,
        Categories $categoriesModel,
        Session $session, DataPersistorInterface $dataPersistor

    )
    {
        parent::__construct($context);
        $this->categoriesModel = $categoriesModel;
        $this->session = $session;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue('category');
        $storeId = $this->dataPersistor->get('store');
        $data['store'] = $storeId;
        $model = $this->categoriesModel;

        try {
            $this->session->setFormData($data);

            if (!$data['store']) {
                throw new \Exception(__('Please select a store.'));
            }
            $model->setData($data)->save();

            $this->messageManager->addSuccess(__('Saved.'));

            $this->session->setFormData(false);

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), 'store' => $data['store'], '_current' => true]);
            }

        } catch (\Exception $e) {
            $this->messageManager->addException($e, __($e->getMessage()));
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());;
        }

        return $resultRedirect->setPath('*/*/', ['store' => $data['store'], '_current' => true]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::categories');
    }
}

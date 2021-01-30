<?php

namespace Extensa\Careers\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

class Categories extends AbstractModel
{
    protected $storeManager;

    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context, $registry);
    }

    protected function _construct()
    {
        $this->_init(\Extensa\Careers\Model\ResourceModel\Categories::class);
    }

    public function getStoreBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
    }

}

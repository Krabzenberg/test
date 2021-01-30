<?php

namespace Extensa\Careers\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Extensa\Careers\Model\CategoriesFactory;
use Extensa\Careers\Model\JobsFactory;

class Careers extends Template
{
    private $scopeConfig;
    private $categoriesFactory;
    private $jobsFactory;
    private $storeManager;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        CategoriesFactory $categoriesFactory,
        JobsFactory $jobsFactory,
        array $data = []
    )
    {
        parent::__construct($context);

        $this->storeManager = $context->getStoreManager();
        $this->scopeConfig = $scopeConfig;
        $this->categoriesFactory = $categoriesFactory;
        $this->jobsFactory = $jobsFactory;
    }

    public function getCategories()
    {
        return $this->categoriesFactory->create()
            ->getCollection()->addFilter('store', $this->storeManager->getStore()->getId());
    }

    public function getJobs()
    {
        return $this->jobsFactory->create()
            ->getCollection()
            ->addFilter('store', $this->storeManager->getStore()->getId());
    }

    public function getTitle()
    {
        return $this->scopeConfig->getValue('extensa_careers/settings/title', ScopeInterface::SCOPE_STORE);
    }
}

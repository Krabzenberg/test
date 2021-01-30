<?php

namespace Extensa\Careers\Model\Options;

use Magento\Store\Model\StoreManagerInterface;

class Stores implements \Magento\Framework\Option\ArrayInterface
{
    private $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function getOptionArray()
    {
        $stores = $this->storeManager->getStores();

        $options = [];
        foreach ($stores as $store) {
            $options[$store->getId()] = $store->getName();
        }

        return $options;
    }

    public function toOptionArray()
    {
        $stores = $this->storeManager->getStores();

        $options = [];
        foreach ($stores as $store) {
            $options[] = ['value' => $store->getId(), 'label' => $store->getName()];
        }

        return $options;
    }
}

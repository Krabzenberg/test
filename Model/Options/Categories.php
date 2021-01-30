<?php

namespace Extensa\Careers\Model\Options;

use Magento\Framework\App\RequestInterface;
use Extensa\Careers\Model\ResourceModel\Categories\Collection as CategoriesCollection;

class Categories implements \Magento\Framework\Option\ArrayInterface
{
    private $request;
    private $categoriesCollection;

    public function __construct(
        RequestInterface $request,
        CategoriesCollection $categoriesCollection
    )
    {
        $this->request = $request;
        $this->categoriesCollection = $categoriesCollection;
    }

    private function getCollection()
    {
        $collection = $this->categoriesCollection;
        if ($this->request->getParam('store') !== null) {
            $collection->addFilter('store', $this->request->getParam('store'));
        }
        return $collection;
    }

    public function getOptionArray()
    {
        $collection = $this->getCollection();

        $options = [];
        if ($collection->count()) {
            foreach ($collection as $category) {
                $options[$category->getId()] = $category->getName();
            }
        }

        return $options;
    }

    public function toOptionArray()
    {
        $collection = $this->getCollection();

        $options = [];
        if ($collection->count()) {
            foreach ($collection as $category) {
                $options[] = ['label' => $category->getName(),'value' => $category->getId()];
            }
        }

        return $options;
    }
}

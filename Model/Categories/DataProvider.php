<?php

namespace Extensa\Careers\Model\Categories;

use Extensa\Careers\Model\ResourceModel\Categories\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        DataPersistorInterface $dataPersistor,
        RequestInterface $request,
        Registry $registry,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $contactCollectionFactory->create();
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
        $this->registry = $registry;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];
        $this->dataPersistor->set('store', $this->request->getParam('store'));
        foreach ($items as $item) {
            $tmp = $item->getData();
            $tmp['store'] = $this->request->getParam('store');

            $this->loadedData[$item->getId()]['category'] = $item->getData();
        }

        return $this->loadedData;

    }
}

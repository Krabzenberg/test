<?php

namespace Extensa\Careers\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PostActions extends Column
{
    const EDIT_CARD = 'careers/categories/edit';
    const DELETE_CARD = 'careers/categories/delete';
    const EDIT_POSITION = 'careers/jobs/edit';
    const DELETE_POSITION = 'careers/jobs/delete';

    protected $urlBuilder;
    private $editUrlCard;
    private $deleteUrlCard;
    private $editUrlPosition;
    private $deleteUrlPosition;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrlCard = self::EDIT_CARD,
        $deleteUrlCard = self::DELETE_CARD,
        $editUrlPosition = self::EDIT_POSITION,
        $deleteUrlPosition = self::DELETE_POSITION
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->editUrlCard = $editUrlCard;
        $this->deleteUrlCard = $deleteUrlCard;
        $this->editUrlPosition = $editUrlPosition;
        $this->deleteUrlPosition = $deleteUrlPosition;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                if (isset($item['category_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl($this->editUrlCard, ['id' => $item['category_id'], 'store' => $item['store']]),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl($this->deleteUrlCard, ['id' => $item['category_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "' . $item['name'] . '"'),
                                'message' => __('Are you sure you wan\'t to delete a "' . $item['name'] . '" record?')
                            ]
                        ]
                    ];
                }

                if (isset($item['job_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder
                                ->getUrl($this->editUrlPosition, ['id' => $item['job_id'], 'store' => $item['store']]),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder
                                ->getUrl($this->deleteUrlPosition, ['id' => $item['job_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "' . $item['name'] . '"'),
                                'message' => __('Are you sure you wan\'t to delete a "' . $item['name'] . '" record?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}

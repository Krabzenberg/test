<?php

namespace Extensa\Careers\Block\Adminhtml\Categories;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AddButton extends GenericButton implements ButtonProviderInterface
{
    private $request;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    )
    {
        parent::__construct($context, $registry);
        $this->request = $context->getRequest();
    }

    public function getButtonData()
    {
        return [
            'label' => __('Add New Category'),
            'class' => 'primary',
            'on_click' => "setLocation('{$this->getAddUrl()}')",
            'sort_order' => 100
        ];
    }

    public function getAddUrl()
    {
        return $this->getUrl('*/*/add', ['store' => $this->request->getParam('store')]);
    }
}

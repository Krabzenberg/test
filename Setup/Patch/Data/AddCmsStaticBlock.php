<?php

namespace Extensa\Careers\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Store\Model\Store;
use Magento\Cms\Model\Block;

class AddCmsStaticBlock implements DataPatchInterface
{
    private $moduleDataSetup;

    private $blockFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        /** @var Block $block */
        $newCmsStaticBlock = [
            'title' => 'Career block',
            'identifier' => 'career-block',
            'is_active' => 1,
            'stores' => Store::DEFAULT_STORE_ID
        ];
        $block = $this->blockFactory->create();
        $block->setData($newCmsStaticBlock)->save();

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}

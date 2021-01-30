<?php

namespace Extensa\Careers\Model;

use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Area;

class Mail
{
    private $inlineTranslation;
    private $transportBuilder;
    private $scopeConfig;
    private $storeManager;

    public function __construct(
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager = null
    )
    {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager ?: ObjectManager::getInstance()->get(StoreManagerInterface::class);
    }

    public function sendMail($type, $from, $vars)
    {
        $templateIdentifier = $this->getTemplateIdentifier($type);
        $to = $this->getConfigValue('email');

        $this->send($from, $to, $vars, $templateIdentifier);

        return true;
    }

    private function getTemplateIdentifier($type)
    {
        $templateIdentifier = '';

        switch ($type) {
            case 'candidate':
                $configTemplateIdentifier = $this->getConfigValue('email_template_application_cv');
                $templateIdentifier = $configTemplateIdentifier ?
                    $configTemplateIdentifier : 'extensa_careers_settings_email_template_application_cv';
                break;

        }

        return $templateIdentifier;
    }

    private function getConfigValue($path)
    {
        return $this->scopeConfig
            ->getValue("extensa_careers/settings/$path", \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    private function send($from, $to, $vars, $templateIdentifier)
    {
        $this->inlineTranslation->suspend();

        try {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateIdentifier)
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars($vars)
                ->setFrom($from)
                ->addTo($to)
                ->getTransport();

            $transport->sendMessage();

        } finally {
            $this->inlineTranslation->resume();
        }
    }
}

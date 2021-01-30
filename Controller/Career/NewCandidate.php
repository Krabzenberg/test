<?php

namespace Extensa\Careers\Controller\Career;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Extensa\Careers\Model\Mail;

class NewCandidate extends Action
{
    private $storeManager;
    private $filesystem;
    private $fileUploaderFactory;
    private $logger;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        UploaderFactory $fileUploaderFactory,
        LoggerInterface $loggerInterface,
        Mail $mail,
        array $data = []
    )
    {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->logger = $loggerInterface;
        $this->mail = $mail;
    }

    public function execute()
    {
        $post = $this->getRequest()->getParams();
        $files = $this->getRequest()->getFiles()->toArray();

        try {
            if (isset($files['resume']) && $files['resume']['name'] != '') {
                $uploader = $this->fileUploaderFactory->create(['fileId' => 'resume']);
                $uploader->setAllowedExtensions(['pdf', 'doc', 'docx']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setAllowCreateFolders(true);
                $path = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
                    ->getAbsolutePath('resume');
                $uploader->save($path);

                $newFileName = $uploader->getUploadedFileName();

                $post['file'] = [
                    'path' => $path . '/' . $newFileName,
                    'name' => $files['resume']['name'],
                    'url' => $this->storeManager->getStore()
                            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'resume/' .
                        $newFileName,
                ];
            } else {
                throw new LocalizedException(__('CV File is missing'));
            }

            $from = ['name' => $post['firstname'] . ' ' . $post['lastname'], 'email' => $post['email']];

            $this->mail->sendMail('candidate', $from, $post);

            $this->messageManager->addSuccess(__('Email sent successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->logger->debug($e->getMessage());
        }

        $this->_redirect($this->_redirect->getRefererUrl());
    }
}

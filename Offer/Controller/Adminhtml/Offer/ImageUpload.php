<?php

declare(strict_types=1);

namespace Yolotest\Offer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Cms\Helper\Wysiwyg\Images;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;

class ImageUpload extends Action implements HttpPostActionInterface
{
    const UPLOAD_DIR = 'wysiwyg/yolotestoffer';

    const ADMIN_RESOURCE = 'Magento_Backend::content';

    private Filesystem\Directory\WriteInterface $mediaDirectory;

    public function __construct(
        private readonly JsonFactory $resultJsonFactory,
        private readonly UploaderFactory $uploaderFactory,
        private readonly Images $cmsWysiwygImages,
        Filesystem $filesystem = null,
        Context $context
    ) {
        parent::__construct($context);
        $filesystem = $filesystem ?? ObjectManager::getInstance()->create(Filesystem::class);
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }

    /**
     * Allow users to upload images to the folder structure
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $fieldName = $this->getRequest()->getParam('param_name');
        $fileUploader = $this->uploaderFactory->create(['fileId' => $fieldName]);

        // Set our parameters
        $fileUploader->setFilesDispersion(false);
        $fileUploader->setAllowRenameFiles(true);
        $fileUploader->setAllowedExtensions(['jpg', 'png']);
        $fileUploader->setAllowCreateFolders(true);

        try {
            if (!$fileUploader->checkMimeType(['image/png', 'image/jpeg'])) {
                throw new \Magento\Framework\Exception\LocalizedException(__('File validation failed.'));
            }

            $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath(self::UPLOAD_DIR));
            $baseUrl = $this->_backendUrl->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]);
            $result['id'] = $this->cmsWysiwygImages->idEncode($result['file']);
            $result['url'] = $baseUrl . rtrim(self::UPLOAD_DIR, '/') . '/' . ltrim($result['file'], '/');
        } catch (\Exception $e) {
            $result = [
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode()
            ];
        }
        return $this->resultJsonFactory->create()->setData($result);
    }

}

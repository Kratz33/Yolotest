<?php

namespace Yolotest\Offer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Yolotest\Offer\Api\OfferRepositoryInterface;
use Yolotest\Offer\Model\OfferFactory;

class Save extends Action
{

    const UPLOAD_DIR = 'wysiwyg/yolotestoffer';

    /**
     * @param Action\Context $context
     * @param OfferFactory $offerFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context                 $context,
        private readonly OfferFactory  $offerFactory,
        private readonly OfferRepositoryInterface $offerRepository,
        private DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('*/*/');
        }

        try {
            $offer = $this->offerFactory->create();
            if (isset($data['offer_id'])) {
                $offer->load($data['offer_id']);
            }

            unset($data['form_key']);
            if ("" == $data['offer_id']) {
                unset($data['offer_id']);
            }

            // CategoryIds
            if (isset($data['category_ids']) && is_array($data['category_ids'])) {
                $data['category_ids'] = implode(',', $data['category_ids']);
            } else {
                $data['category_ids'] = '';
            }

            // image upload
            if (isset($data['image'][0]['file'])) {
                // direct upload
                $fullPath = self::UPLOAD_DIR . '/' . $data['image'][0]['file'];
            } elseif (isset($data['image'][0]['url'])) {
                // load from gallery
                $fullPath = str_replace('/media/', '', strstr($data['image'][0]['url'], '/media/'));
            }
            $data['image'] = $fullPath ?? null;
            $offer->addData($data);
            $this->offerRepository->save($offer);

            $this->messageManager->addSuccessMessage(__('Offer saved successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error saving offer: %1', $e->getMessage()));
            $this->dataPersistor->set('offer_data', $data);
        }

        return $this->_redirect('*/*/');
    }

    /**
     * Check if the user has permission to edit/save
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Yolotest_Offer::offer_edit');
    }
}

<?php

namespace Yolotest\Offer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Yolotest\Offer\Api\OfferRepositoryInterface;

class Delete extends Action
{

    /**
     * @param Action\Context $context
     * @param OfferRepositoryInterface $offerRepository
     */
    public function __construct(
        Action\Context                            $context,
        private readonly OfferRepositoryInterface $offerRepository
    )
    {
        parent::__construct($context);
    }

    /**
     * Execute the delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $offerId = $this->getRequest()->getParam('offer_id');

        if ($offerId) {
            try {
                $this->offerRepository->deleteById($offerId);
                $this->messageManager->addSuccessMessage(__('The offer has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('An error occurred while deleting the offer.'));
            }
            return $resultRedirect->setPath('*/*/edit', ['offer_id' => $offerId]);
        }

        $this->messageManager->addErrorMessage(__('We can\'t find an offer to delete.'));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check if the user has permission to delete
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Yolotest_Offer::offer_delete');
    }
}

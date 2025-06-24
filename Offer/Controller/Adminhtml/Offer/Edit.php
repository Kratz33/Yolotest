<?php

namespace Yolotest\Offer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Yolotest\Offer\Api\OfferRepositoryInterface;
use Yolotest\Offer\Model\OfferFactory;

class Edit extends Action
{

    const ADMIN_RESOURCE = 'Yolotest_Offer::offer_edit';

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context               $context,
        private readonly PageFactory $resultPageFactory,
        private readonly OfferFactory $offerFactory,
        private readonly OfferRepositoryInterface $repository,

    )
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('offer_id');
        if ($id) {
            try {
                $entity = $this->repository->get($id);
            } catch (NoSuchEntityException) {
                $this->messageManager->addErrorMessage(__('This offer no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $entity = $this->offerFactory->create();
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Yolotest::offer')
            ->addBreadcrumb(__('Yolotest'), __('Yolotest'))
            ->addBreadcrumb(__('Offer'), __('Offer'));
        $resultPage->getConfig()->getTitle()->prepend(__('Offers'));
        $resultPage->getConfig()->getTitle()->prepend($entity->getId() ? $entity->getLabel() : __('New Offer'));
        return $resultPage;
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

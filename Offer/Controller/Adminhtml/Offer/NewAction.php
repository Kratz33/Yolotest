<?php

namespace Yolotest\Offer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;


class NewAction extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Yolotest_offer::offer_edit';

    /**
     * @return \Magento\Framework\App\ResponseInterface|Forward|\Magento\Framework\Controller\Result\Redirect|ResultInterface
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        if ($this->_isAllowed(self::ADMIN_RESOURCE)) {
            return $resultForward->forward('edit');
        }

        $this->messageManager->addErrorMessage(__('You do not have permission to edit offers.'));
        return $this->resultRedirectFactory->create()->setPath('admin/dashboard');
    }
}

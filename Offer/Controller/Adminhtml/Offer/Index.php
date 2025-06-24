<?php

namespace Yolotest\Offer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context               $context,
        private readonly PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Yolotest_Offer::offers');
        $resultPage->getConfig()->getTitle()->prepend(__('Offers'));
        return $resultPage;
    }

    /**
     * Check if the user has permission to access offers
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Yolotest_Offer::offer');
    }
}

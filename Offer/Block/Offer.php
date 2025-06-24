<?php

namespace Yolotest\Offer\Block;

use Magento\Framework\View\Element\Template;
use Yolotest\Offer\Model\ResourceModel\Offer\CollectionFactory;

class Offer extends Template
{
    private CollectionFactory $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getOffers(): array
    {
        $currentCategoryId = $this->getRequest()->getParam('id');
        $currentDate = (new \DateTime())->format('Y-m-d H:i:s');

        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('category_ids', ['finset' => $currentCategoryId])
            ->addFieldToFilter('start_date', ['lteq' => $currentDate])
            ->addFieldToFilter('end_date', ['gteq' => $currentDate]);

        return $collection->getItems();
    }

    public function getMediaUrl()
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]);
    }
}

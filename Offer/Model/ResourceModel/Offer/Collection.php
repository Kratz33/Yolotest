<?php

namespace Yolotest\Offer\Model\ResourceModel\Offer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Yolotest\Offer\Model\Offer;
use Yolotest\Offer\Model\ResourceModel\Offer as OfferResource;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'offer_id';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Offer::class,OfferResource::class);
    }
}

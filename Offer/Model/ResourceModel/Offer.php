<?php

namespace Yolotest\Offer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Yolotest\Offer\Api\Data\OfferInterface;

class Offer extends AbstractDb
{
    public const TABLE_NAME = 'yolotest_offer';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, OfferInterface::OFFER_ID);
    }
}

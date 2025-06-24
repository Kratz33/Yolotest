<?php

declare(strict_types=1);

namespace Yolotest\Offer\Model;

use Magento\Framework\Model\AbstractModel;
use Yolotest\Offer\Api\Data\OfferInterface;
use Yolotest\Offer\Model\ResourceModel\Offer as OfferResource;

class Offer extends AbstractModel implements OfferInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'yolotest_offer';

    protected $_eventObject = 'yolotest_offer';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(OfferResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getOfferId(): ?int
    {
        return (int)$this->getData(self::OFFER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOfferId(int $offerId): OfferInterface
    {
        return $this->setData(self::OFFER_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return $this->getData(self::LABEL);
    }

    /**
     * @inheritDoc
     */
    public function setLabel(string $label): OfferInterface
    {
        return $this->setData(self::LABEL, $label);
    }

    /**
     * @inheritDoc
     */
    public function getImage(): string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $image): OfferInterface
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl(): string
    {
        return $this->getData(self::REDIRECT_URL);
    }

    /**
     * @inheritDoc
     */
    public function setRedirectUrl(string $redirectUrl): OfferInterface
    {
        return $this->setData(self::REDIRECT_URL, $redirectUrl);
    }

    /**
     * @inheritDoc
     */
    public function getCategoryIds(): string
    {
        return $this->getData(self::CATEGORY_IDS);
    }

    /**
     * @inheritDoc
     */
    public function setCategoryIds(string $categoryIds): OfferInterface
    {
        return $this->setData(self::CATEGORY_IDS, $categoryIds);
    }

    /**
     * @inheritDoc
     */
    public function getStartDate(): string
    {
        return $this->getData(self::START_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setStartDate(string $startDate): OfferInterface
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * @inheritDoc
     */
    public function getEndDate(): string
    {
        return $this->getData(self::END_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setEndDate(string $endDate): OfferInterface
    {
        return $this->setData(self::END_DATE, $endDate);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }
}

<?php

declare(strict_types=1);

namespace Yolotest\Offer\Api\Data;

interface OfferInterface
{
    const OFFER_ID = 'offer_id';
    const LABEL = 'label';
    const IMAGE = 'image';
    const REDIRECT_URL = 'redirect_url';
    const CATEGORY_IDS = 'category_ids';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get Offer ID
     *
     * @return int|null
     */
    public function getOfferId(): ?int;

    /**
     * Set Offer ID
     *
     * @param int $offerId
     * @return OfferInterface
     */
    public function setOfferId(int $offerId): OfferInterface;

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Set Label
     *
     * @param string $label
     * @return OfferInterface
     */
    public function setLabel(string $label): OfferInterface;

    /**
     * Get Image
     *
     * @return string
     */
    public function getImage(): string;

    /**
     * Set Image
     *
     * @param string $image
     * @return OfferInterface
     */
    public function setImage(string $image): OfferInterface;

    /**
     * Get Redirect URL
     *
     * @return string
     */
    public function getRedirectUrl(): string;

    /**
     * Set Redirect URL
     *
     * @param string $redirectUrl
     * @return OfferInterface
     */
    public function setRedirectUrl(string $redirectUrl): OfferInterface;

    /**
     * Get Category IDs
     *
     * @return string
     */
    public function getCategoryIds(): string;

    /**
     * Set Category IDs
     *
     * @param string $categoryIds
     * @return OfferInterface
     */
    public function setCategoryIds(string $categoryIds): OfferInterface;

    /**
     * Get Start Date
     *
     * @return string
     */
    public function getStartDate(): string;

    /**
     * Set Start Date
     *
     * @param string $startDate
     * @return OfferInterface
     */
    public function setStartDate(string $startDate): OfferInterface;

    /**
     * Get End Date
     *
     * @return string
     */
    public function getEndDate(): string;

    /**
     * Set End Date
     *
     * @param string $endDate
     * @return OfferInterface
     */
    public function setEndDate(string $endDate): OfferInterface;

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Get Updated At
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;
}

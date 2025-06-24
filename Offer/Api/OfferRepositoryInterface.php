<?php

namespace Yolotest\Offer\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Yolotest\Offer\Api\Data\OfferInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface OfferRepositoryInterface
{
    /**
     * Save an offer.
     *
     * @param OfferInterface $offer
     * @return OfferInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(OfferInterface $offer): OfferInterface;

    /**
     * Delete Offer
     *
     * @param OfferInterface $offer
     * @return bool
     * @throws LocalizedException
     * @throws CouldNotDeleteException
     */
    public function delete(OfferInterface $offer): bool;

    /**
     * Delete an offer by its ID.
     *
     * @param int $offerId
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $offerId): void;

    /**
     * Get Terminal By Id
     *
     * @param  int $id
     * @return TerminalInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    /**
     * @param int $id
     * @return OfferInterface
     */
    public function get(int $id): OfferInterface;

}

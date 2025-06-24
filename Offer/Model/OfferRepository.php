<?php

namespace Yolotest\Offer\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Yolotest\Offer\Api\Data\OfferInterface;
use Yolotest\Offer\Api\OfferRepositoryInterface;
use Yolotest\Offer\Model\ResourceModel\Offer as OfferResource;

class OfferRepository implements OfferRepositoryInterface
{

    /**
     * @param OfferResource $offerResource
     * @param OfferFactory $offerFactory
     */
    public function __construct(
        private readonly OfferResource $offerResource,
        private readonly OfferFactory $offerFactory
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function save(OfferInterface $offer): OfferInterface
    {
        try {
            $this->offerResource->save($offer);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save the offer: %1', $e->getMessage()));
        }

        return $offer;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $offerId): void
    {
        $offer = $this->offerFactory->create();
        $this->offerResource->load($offer, $offerId);

        if (!$offer->getId()) {
            throw new NoSuchEntityException(__('The offer with ID "%1" does not exist.', $offerId));
        }

        try {
            $this->offerResource->delete($offer);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete the offer: %1', $e->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OfferInterface $offer): bool
    {
        try {
            $this->offerResource->delete($offer);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete the Offer.'), $e);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id): OfferInterface
    {
        $offer = $this->offerFactory->create();
        $this->offerResource->load($offer, $id);
        if (!$offer->getId()) {
            throw new NoSuchEntityException(__("No Offer found with this id: $id"));
        }
        return $offer;
    }

}

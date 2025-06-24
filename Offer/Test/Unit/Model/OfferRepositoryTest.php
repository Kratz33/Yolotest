<?php

declare(strict_types=1);

namespace Yolotest\Offer\Test\Unit\Api;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yolotest\Offer\Api\OfferRepositoryInterface;
use Yolotest\Offer\Model\Offer;

class OfferRepositoryTest extends TestCase
{
    private $offerRepository;
    private $objectManager;

    protected function setUp(): void
    {
        $this->offerRepository = $this->createMock(OfferRepositoryInterface::class);
        $this->objectManager = new ObjectManager($this);
    }

    public function testSave(): void
    {
        $offer = $this->objectManager->getObject(Offer::class);
        $offer->setData([
            'offer_id' => 1,
            'label' => 'Test Label',
            'image' => 'test_image.jpg',
            'redirect_url' => 'https://example.com',
            'category_ids' => '6,175',
            'start_date' => '2025-01-01 00:00:00',
            'end_date' => '2025-12-31 23:59:59',
            'created_at' => '2025-01-01 12:00:00',
            'updated_at' => '2025-01-02 12:00:00',
        ]);

        $this->offerRepository->expects($this->once())->method('save')->with($offer);

        $this->offerRepository->save($offer);
    }

    public function testGetById(): void
    {
        $offer = $this->objectManager->getObject(Offer::class);
        $offer->setData(['offer_id' => 1]);

        $this->offerRepository->method('get')->willReturn($offer);

        $result = $this->offerRepository->get(1);

        $this->assertEquals(1, $result->getData('offer_id'));
    }
}

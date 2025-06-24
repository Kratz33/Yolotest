<?php

declare(strict_types=1);

namespace Yolotest\Offer\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yolotest\Offer\Model\Offer;

class OfferTest extends TestCase
{
    private $offer;

    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->offer = $objectManager->getObject(Offer::class);
    }

    public function testOfferIdField(): void
    {
        $this->offer->setData('offer_id', 1);
        $this->assertEquals(1, $this->offer->getData('offer_id'));
    }

    public function testLabelField(): void
    {

        $this->offer->setData('label', 'Test Label');
        $this->assertEquals('Test Label', $this->offer->getData('label'));
    }

    public function testImageField(): void
    {
        $this->offer->setData('image', 'test_image.jpg');
        $this->assertEquals('test_image.jpg', $this->offer->getData('image'));
    }

    public function testRedirectUrlField(): void
    {
        $this->offer->setData('redirect_url', 'https://example.com');
        $this->assertEquals('https://example.com', $this->offer->getData('redirect_url'));
    }

    public function testCategoryIdsField(): void
    {
        $this->offer->setData('category_ids', '6,175');
        $this->assertEquals('6,175', $this->offer->getData('category_ids'));
    }

    public function testStartDateField(): void
    {
        $this->offer->setData('start_date', '2025-01-01 00:00:00');
        $this->assertEquals('2025-01-01 00:00:00', $this->offer->getData('start_date'));
    }

    public function testEndDateField(): void
    {
        $this->offer->setData('end_date', '2025-12-31 23:59:59');
        $this->assertEquals('2025-12-31 23:59:59', $this->offer->getData('end_date'));
    }

    public function testCreatedAtField(): void
    {
        $this->offer->setData('created_at', '2025-01-01 12:00:00');
        $this->assertEquals('2025-01-01 12:00:00', $this->offer->getData('created_at'));
    }

    public function testUpdatedAtField(): void
    {
        $this->offer->setData('updated_at', '2025-01-02 12:00:00');
        $this->assertEquals('2025-01-02 12:00:00', $this->offer->getData('updated_at'));
    }

    public function testUnsetData(): void
    {
        $this->offer->setData('label', 'Test Label');
        $this->offer->unsetData('label');

        $this->assertNull($this->offer->getData('label'));
    }

    public function testDefaultValues(): void
    {
        $this->assertNull($this->offer->getData('offer_id'));
        $this->assertNull($this->offer->getData('created_at'));
        $this->assertNull($this->offer->getData('updated_at'));
    }

    public function testSetAndGetMultipleData(): void
    {
        $data = [
            'offer_id' => 1,
            'label' => 'Test Label',
            'image' => 'test_image.jpg',
        ];

        $this->offer->setData($data);

        $this->assertEquals(1, $this->offer->getData('offer_id'));
        $this->assertEquals('Test Label', $this->offer->getData('label'));
        $this->assertEquals('test_image.jpg', $this->offer->getData('image'));
    }

    public function testHasData(): void
    {
        $this->offer->setData('label', 'Test Label');

        $this->assertTrue($this->offer->hasData('label'));
        $this->assertFalse($this->offer->hasData('image'));
    }
}

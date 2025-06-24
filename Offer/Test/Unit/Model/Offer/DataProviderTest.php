<?php

declare(strict_types=1);

namespace Yolotest\Offer\Test\Unit\Model\Offer;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Store;
use PHPUnit\Framework\TestCase;
use Yolotest\Offer\Model\OfferRepository;
use Yolotest\Offer\Model\ResourceModel\Offer\Collection;
use Yolotest\Offer\Model\Offer\DataProvider;
use Yolotest\Offer\Model\Offer;

class DataProviderTest extends TestCase
{
    private $offerRepositoryMock;
    private $searchCriteriaMock;
    private $searchResultsMock;
    private $storeManagerMock;
    private $storeMock;
    private $filesystemMock;
    private $collectionMock;
    private $metaMock;
    private $dataMock;
    private $dataProvider;

    protected function setUp(): void
    {
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->storeMock = $this->createMock(Store::class);
        $this->filesystemMock = $this->createMock(Filesystem::class);
        $mediaDirectoryMock = $this->createMock(WriteInterface::class);
        $mediaDirectoryMock->method('stat')->willReturn(['size' => 12345]);
        $this->collectionMock = $this->createMock(Collection::class);

        $this->metaMock = ['meta_key' => 'meta_value'];
        $this->dataMock = ['data_key' => 'data_value'];

        $this->filesystemMock->method('getDirectoryWrite')->willReturn($mediaDirectoryMock);
        $this->storeManagerMock->method('getStore')->willReturn($this->storeMock);
        $this->storeMock->method('getBaseUrl')->willReturn('http://example.com/');

        $objectManager = new ObjectManager($this);
        $this->dataProvider = $objectManager->getObject(
            DataProvider::class,
            [
                'storeManager' => $this->storeManagerMock,
                'name' => 'offer_listing',
                'primaryFieldName' => 'offer_id',
                'requestFieldName' => 'offer_id',
                'filesystem' => $this->filesystemMock,
                'collection' => $this->collectionMock,
                'meta' => $this->metaMock,
                'data' => $this->dataMock,
            ]
        );
    }

    private function prepareMockData(): void
    {
        $offerMock1 = $this->createMock(Offer::class);
        $offerMock1->method('getId')->willReturn(1);
        $offerMock1->method('getData')->willReturn([
            'offer_id' => 1,
            'label' => 'Test Label',
            'image' => 'test_image.jpg',
            'redirect_url' => 'https://example.com/test',
            'category_ids' => '1,2,3',
            'start_date' => '2023-10-01 00:00:00',
            'end_date' => '2023-10-31 23:59:59',
        ]);

        $offerMock2 = $this->createMock(Offer::class);
        $offerMock2->method('getId')->willReturn(2);
        $offerMock2->method('getData')->willReturn([
            'offer_id' => 2,
            'label' => 'Another Label',
            'image' => 'another_image.jpg',
            'redirect_url' => 'https://example.com/another',
            'category_ids' => '4,5,6',
            'start_date' => '2023-11-01 00:00:00',
            'end_date' => '2023-11-30 23:59:59',
        ]);

        $this->collectionMock->method('getItems')->willReturn([$offerMock1, $offerMock2]);
    }

    public function testCount(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertCount(2, $result);
    }

    public function testKeys(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertArrayHasKey(1, $result);
        $this->assertArrayHasKey(2, $result);
    }

    public function testLabels(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertEquals('Test Label', $result[1]['label']);
        $this->assertEquals('Another Label', $result[2]['label']);
    }

    public function testImages(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertArrayHasKey('image', $result[1]);
        $this->assertArrayHasKey('image', $result[2]);
        $this->assertEquals('test_image.jpg', $result[1]['image'][0]['name']);
        $this->assertEquals('http://example.com/test_image.jpg', $result[1]['image'][0]['url']);
        $this->assertEquals('another_image.jpg', $result[2]['image'][0]['name']);
        $this->assertEquals('http://example.com/another_image.jpg', $result[2]['image'][0]['url']);
        $this->assertEquals(12345, $result[1]['image'][0]['size']);
        $this->assertEquals(12345, $result[2]['image'][0]['size']);
    }

    public function testRedirectUrls(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertEquals('https://example.com/test', $result[1]['redirect_url']);
        $this->assertEquals('https://example.com/another', $result[2]['redirect_url']);
    }

    public function testCategoryIds(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertEquals('1,2,3', $result[1]['category_ids']);
        $this->assertEquals('4,5,6', $result[2]['category_ids']);
    }

    public function testDates(): void
    {
        $this->prepareMockData();
        $result = $this->dataProvider->getData();
        $this->assertEquals('2023-10-01 00:00:00', $result[1]['start_date']);
        $this->assertEquals('2023-10-31 23:59:59', $result[1]['end_date']);
        $this->assertEquals('2023-11-01 00:00:00', $result[2]['start_date']);
        $this->assertEquals('2023-11-30 23:59:59', $result[2]['end_date']);
    }
}

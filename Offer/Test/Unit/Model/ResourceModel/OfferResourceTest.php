<?php

declare(strict_types=1);

namespace Yolotest\Offer\Test\Unit\Model\ResourceModel;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yolotest\Offer\Model\ResourceModel\Offer;

class OfferResourceTest extends TestCase
{
    private $offerResource;
    private $dbAdapterMock;

    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        // Mock de l'adaptateur de base de données
        $this->dbAdapterMock = $this->createMock(AdapterInterface::class);

        // Configuration pour simuler les méthodes de transaction
        $this->dbAdapterMock->method('beginTransaction')->willReturn(true);
        $this->dbAdapterMock->method('commit')->willReturn(true);
        $this->dbAdapterMock->method('rollBack')->willReturn(true);

        // Instanciation de la ressource avec le mock
        $this->offerResource = $objectManager->getObject(
            Offer::class,
            ['connection' => $this->dbAdapterMock]
        );
    }

    public function testSave(): void
    {
        $offerMock = $this->createMock(AbstractModel::class);
        $offerMock->expects($this->once())->method('getId')->willReturn(1);

        $this->offerResource->save($offerMock);

        $this->assertEquals(1, $offerMock->getId());
    }
}

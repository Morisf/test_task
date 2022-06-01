<?php

namespace App\Tests\Unit\Service;

use App\Repository\OrderRepository;
use App\Repository\StationRepository;
use App\Service\EquipmentService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EquipmentServiceTest extends TestCase
{
    public function testSomething(): void
    {
        $manager = $this->createMock(EntityManagerInterface::class);
        $stationRepo = $this->createMock(StationRepository::class);
        $orderRepo = $this->createMock(OrderRepository::class);

        $manager->expects($this->exactly(2))
            ->method('getRepository')
            ->willReturnOnConsecutiveCalls($stationRepo, $orderRepo);

        $stationRepo->expects($this->once())->method('getAvailableStationEquipment')->with(1)->willReturn([]);
        $orderRepo->expects($this->once())->method('getOrderedEquipmentByStation')->with(1)->willReturn([]);

        $service = new EquipmentService($manager);
        $result = $service->getEquipmentForTomorrow(1);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('availableEquipment', $result);
        $this->assertArrayHasKey('orderedEquipment', $result);
    }
}

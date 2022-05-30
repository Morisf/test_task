<?php

namespace App\Service;

use App\Entity\Equipment;
use App\Entity\Order;
use App\Entity\Station;
use App\Exceptions\StationNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class EquipmentService
{
    private EntityManagerInterface $manger;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manger = $manager;
    }

    public function getEquipmentForTomorrow(int $stationId): array
    {
        $result = [];
        $result['availableEquipment'] = $this->manger
            ->getRepository(Station::class)
            ->getAvailableStationEquipment($stationId);
        $result['orderedEquipment'] = $this->manger
            ->getRepository(Order::class)
            ->getOrderedEquipmentByStation($stationId)
        ;

        return $result;
    }
}

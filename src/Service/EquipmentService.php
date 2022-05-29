<?php

namespace App\Service;

use App\Entity\Equipment;
use App\Entity\Iterable\IterableEquipment;
use App\Exceptions\StationNotFoundException;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;

class EquipmentService
{
    private EntityManagerInterface $manger;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manger = $manager;
    }

    public function getEquipmentByDay(string $date, int $stationId): array
    {
        $station = $this->manger->getRepository(StationRepository::class)->find($stationId);
        if (!$station) {
            throw new StationNotFoundException("Stations with id:{$stationId} not found");
        }
        $equipment = $station->getLocalEquipment();


        return $this->manger->getRepository(Equipment::class)->getEquipmentByDay(new \DateTime($date), $station);
    }
}

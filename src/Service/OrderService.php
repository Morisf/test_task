<?php

namespace App\Service;

use App\Entity\Camper;
use App\Entity\Equipment;
use App\Entity\LocationEquipment;
use App\Entity\Order;
use App\Entity\OrderEquipment;
use App\Entity\Station;
use App\Exceptions\EquipmentNotFoundException;
use App\Exceptions\NotEnoughEquipmentException;
use App\Exceptions\StationNotFoundException;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class OrderService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function finishOpenOrders(): void
    {
        $this->entityManager->getRepository(Order::class)->finishOpenOrders();
    }

    /**
     * @param array $data
     * @return Order
     * @throws EquipmentNotFoundException
     * @throws NotEnoughEquipmentException
     * @throws StationNotFoundException
     */
    public function createOrder(array $data): Order
    {
        [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'startLocation' => $startLocation,
            'endLocation' => $endLocation,
            'equipment' => $equipments,
            'camperId' => $camperId,
        ] = $data;

        $order = $this->storeOrder($startDate,$endDate,$startLocation,$endLocation,$equipments,$camperId);
        $this->updateQuantity($startLocation, $equipments);

        return $order;
    }

    private function locationEquipmentEnough(Station $startLocation, int $quantity): bool
    {
        $locationEquipmentRepository = $this->entityManager->getRepository(LocationEquipment::class);
        $locationEquipment = $locationEquipmentRepository->findOneBy([
            'location' => $startLocation
        ]);

        return ($locationEquipment && $locationEquipment->getQuantity() >= $quantity);
    }

    /**
     * @param mixed $equipments
     * @param EntityRepository|EquipmentRepository $equipmentRepositoryRepository
     * @param mixed $startStation
     * @param Order $order
     * @return void
     * @throws EquipmentNotFoundException
     * @throws NotEnoughEquipmentException
     */
    private function setOrderEquipment(
        mixed $equipments,
        EntityRepository|EquipmentRepository $equipmentRepositoryRepository,
        mixed $startStation,
        Order $order
    ): void {
        foreach ($equipments as $item) {
            $equipment = $equipmentRepositoryRepository->find($item['id']);
            if (!$equipment) {
                throw new EquipmentNotFoundException();
            }
            if (!$this->locationEquipmentEnough($startStation, $item['quantity'])) {
                throw new NotEnoughEquipmentException();
            }
            $orderedEquipment = new OrderEquipment();
            $orderedEquipment->setOrders($order);
            $orderedEquipment->setEquipment($equipment);
            $orderedEquipment->setOrderedEquipmentQty($item['quantity']);
            $this->entityManager->persist($orderedEquipment);
        }
    }

    /**
     * @throws EquipmentNotFoundException
     * @throws StationNotFoundException
     * @throws NotEnoughEquipmentException
     * @throws \Exception
     */
    private function storeOrder(
        string $startDate,
        string $endDate,
        int $startLocation,
        int $endLocation,
        array $equipments,
        ?int $camperId
    ): Order {
        $stationRepository = $this->entityManager->getRepository(Station::class);
        $camperRepository = $this->entityManager->getRepository(Camper::class);
        $equipmentRepositoryRepository = $this->entityManager->getRepository(Equipment::class);

        $startStation = $stationRepository->find($startLocation);
        $endStation = $stationRepository->find($endLocation);

        if (!$startStation) {
            throw new StationNotFoundException("Station with id:{$startStation}");
        }

        if(!$endStation) {
            throw new StationNotFoundException("Station with id:{$endStation}");
        }

        $order = new Order();
        $order->setStartDate((new \DateTime($startDate)));
        $order->setEndDate((new \DateTime($endDate)));
        $order->setStartLocation($stationRepository->find($startLocation));
        $order->setEndLocation($stationRepository->find($endLocation));
        $this->setOrderEquipment($equipments, $equipmentRepositoryRepository, $startStation, $order);

        if($camperId) {
            $order->setCamper($camperRepository->find($camperId));
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    private function updateQuantity(
        int $startLocation,
        array $equipments,
    ): void {
        $stationRepository = $this->entityManager->getRepository(Station::class);
        $station = $stationRepository->find($startLocation);
        foreach ($station->getLocalEquipment() as $equipment) {
            array_walk($equipments, function ($item) use ($equipment)
            {
                if ($item['id'] === $equipment->getEquipment()->getId()) {
                    $equipment->setQuantity($equipment->getQuantity() - $item['quantity']);
                    $this->entityManager->persist($equipment);
                }
            });
        }

        $this->entityManager->flush();
    }
}

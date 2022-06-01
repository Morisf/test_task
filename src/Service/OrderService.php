<?php

namespace App\Service;

use App\Entity\Camper;
use App\Entity\Equipment;
use App\Entity\LocationEquipment;
use App\Entity\Order;
use App\Entity\OrderEquipment;
use App\Entity\Station;
use App\Exceptions\EquipmentNotFoundException;
use App\Exceptions\KeyNotFoundException;
use App\Exceptions\NotEnoughEquipmentException;
use App\Exceptions\StationNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

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
     * @throws StationNotFoundException|KeyNotFoundException
     */
    public function createOrder(array $data): Order
    {
        try {
            [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'startLocation' => $startLocation,
                'endLocation' => $endLocation,
                'equipment' => $equipments,
                'camperId' => $camperId,
            ] = $data;
        } catch (\Exception $exception) {
            throw new KeyNotFoundException($exception->getMessage());
        }

        $order = $this->storeOrder($startDate, $endDate, $startLocation, $endLocation, $equipments, $camperId);
        $this->updateQuantity($startLocation, $equipments);

        return $order;
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

        $startStation = $stationRepository->find($startLocation);
        $endStation = $stationRepository->find($endLocation);

        if (!$startStation) {
            throw new StationNotFoundException("Station with id:{$startStation}");
        }

        if (!$endStation) {
            throw new StationNotFoundException("Station with id:{$endStation}");
        }

        $order = new Order();
        $order->setStartDate((new \DateTime($startDate)));
        $order->setEndDate((new \DateTime($endDate)));
        $order->setStartLocation($startStation);
        $order->setEndLocation($endStation);
        $this->setOrderEquipment($equipments, $startStation, $order);

        if ($camperId) {
            $order->setCamper($camperRepository->find($camperId));
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    /**
     * @param Station $startLocation
     * @param int $quantity
     * @return bool
     */
    private function locationEquipmentEnough(Station $startLocation, int $quantity): bool
    {
        $locationEquipmentRepository = $this->entityManager->getRepository(LocationEquipment::class);

        $locationEquipment = $locationEquipmentRepository->findOneBy([
            'location' => $startLocation
        ]);

        return ($locationEquipment && $locationEquipment->getQuantity() >= $quantity);
    }

    /**
     * @param array $equipments
     * @param Station $startStation
     * @param Order $order
     * @return void
     * @throws EquipmentNotFoundException
     * @throws NotEnoughEquipmentException
     */
    private function setOrderEquipment(
        array $equipments,
        Station $startStation,
        Order $order
    ): void {
        $equipmentRepositoryRepository = $this->entityManager->getRepository(Equipment::class);

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

    private function updateQuantity(
        int $startLocation,
        array $equipments,
    ): void {
        $stationRepository = $this->entityManager->getRepository(Station::class);
        $station = $stationRepository->find($startLocation);
        foreach ($station->getLocalEquipment() as $equipment) {
            array_walk($equipments, function ($item) use ($equipment) {
                if ($item['id'] === $equipment->getEquipment()->getId()) {
                    $equipment->setQuantity($equipment->getQuantity() - $item['quantity']);
                    $this->entityManager->persist($equipment);
                }
            });
        }

        $this->entityManager->flush();
    }
}

<?php

namespace App\Entity;

use App\Repository\OrderEquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderEquipmentRepository::class)]
class OrderEquipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Equipment::class)]
    private Equipment $equipment;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $orderedEquipmentQty;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderedEquipment')]
    #[ORM\JoinColumn(nullable: false)]
    private Order $orders;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Equipment
     */
    public function getEquipment(): Equipment
    {
        return $this->equipment;
    }

    /**
     * @param Equipment $equipment
     * @return OrderEquipment
     */
    public function setEquipment(Equipment $equipment): OrderEquipment
    {
        $this->equipment = $equipment;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderedEquipmentQty(): ?int
    {
        return $this->orderedEquipmentQty;
    }

    /**
     * @param int|null $orderedEquipmentQty
     * @return OrderEquipment
     */
    public function setOrderedEquipmentQty(?int $orderedEquipmentQty): OrderEquipment
    {
        $this->orderedEquipmentQty = $orderedEquipmentQty;
        return $this;
    }

    public function getOrders(): Order
    {
        return $this->orders;
    }

    public function setOrders(Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}

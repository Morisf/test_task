<?php

namespace App\Entity;

use App\Repository\LocationEquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationEquipmentRepository::class)]
class LocationEquipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'integer')]
    private int $quantity = 0;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: 'localEquipment')]
    #[ORM\JoinColumn(nullable: false)]
    private Station $location;

    #[ORM\ManyToOne(targetEntity: Equipment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Equipment $equipment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getLocation(): ?Station
    {
        return $this->location;
    }

    public function setLocation(?Station $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getEquipment(): Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
}

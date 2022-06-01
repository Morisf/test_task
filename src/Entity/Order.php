<?php

namespace App\Entity;

use App\Exceptions\WrongOrderStatusException;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELED = 'canceled';

    public const ORDER_STATUS_LIST = [
        self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_DONE,
        self::STATUS_CANCELED,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $startDate;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $endDate;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: 'orderStartLocation')]
    #[ORM\JoinColumn(nullable: false)]
    private Station $startLocation;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Station $endLocation;

    #[ORM\Column(type: 'string', length: 12, nullable: false)]
    private string $orderStatus = self::STATUS_NEW;

    #[ORM\ManyToOne(targetEntity: Camper::class, inversedBy: 'orders')]
    private ?Camper $camper;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: OrderEquipment::class, orphanRemoval: true)]
    private Collection $orderedEquipment;

    public function __construct()
    {
        $this->orderedEquipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStartLocation(): Station
    {
        return $this->startLocation;
    }

    public function setStartLocation(Station $startLocation): self
    {
        $this->startLocation = $startLocation;

        return $this;
    }

    public function getEndLocation(): Station
    {
        return $this->endLocation;
    }

    public function setEndLocation(Station $endLocation): self
    {
        $this->endLocation = $endLocation;

        return $this;
    }

    public function getCamper(): ?Camper
    {
        return $this->camper;
    }

    public function setCamper(?Camper $camper): self
    {
        $this->camper = $camper;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderStatus(): string
    {
        return $this->orderStatus;
    }

    /**
     * @param string $orderStatus
     * @return Order
     * @throws WrongOrderStatusException
     */
    public function setOrderStatus(string $orderStatus): Order
    {
        if (!in_array($orderStatus, self::ORDER_STATUS_LIST)) {
            throw new WrongOrderStatusException("Status of order {$orderStatus} is wrong");
        }

        $this->orderStatus = $orderStatus;
        return $this;
    }

    /**
     * @return Collection<int, OrderEquipment>
     */
    public function getOrderedEquipment(): Collection
    {
        return $this->orderedEquipment;
    }

    public function addOrderedEquipment(OrderEquipment $orderedEquipment): self
    {
        if (!$this->orderedEquipment->contains($orderedEquipment)) {
            $this->orderedEquipment[] = $orderedEquipment;
            $orderedEquipment->setOrders($this);
        }

        return $this;
    }

    public function removeOrderedEquipment(OrderEquipment $orderedEquipment): self
    {
        if ($this->orderedEquipment->removeElement($orderedEquipment)) {
            // set the owning side to null (unless already changed)
            if ($orderedEquipment->getOrders() === $this) {
                $orderedEquipment->setOrders(null);
            }
        }

        return $this;
    }
}

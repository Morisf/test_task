<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[ORM\Table(name: 'equipments')]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\OneToMany(mappedBy: 'orderedEquipment', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Assert\NotBlank]
    private int $price;

    #[ORM\Column(type: 'boolean', nullable: false)]
    #[Assert\NotBlank]
    private bool $oneTimePayment = true;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Equipment
     */
    public function setTitle(string $title): Equipment
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Equipment
     */
    public function setPrice(int $price): Equipment
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOneTimePayment(): bool
    {
        return $this->oneTimePayment;
    }

    /**
     * @param bool $oneTimePayment
     * @return Equipment
     */
    public function setOneTimePayment(bool $oneTimePayment): Equipment
    {
        $this->oneTimePayment = $oneTimePayment;
        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setOrderedEquipment($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if (
            $this->orders->removeElement($order) &&
            $order->getOrderedEquipment() === $this
        ) {
            $order->setOrderedEquipment(null);
        }

        return $this;
    }
}

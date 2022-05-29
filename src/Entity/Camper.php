<?php

namespace App\Entity;

use App\Repository\CamperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CamperRepository::class)]
#[ORM\Table(name: 'campers')]
class Camper
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', nullable: false)]
    private string $brand;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', nullable: false)]
    private string $model;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'integer', nullable: false)]
    private int $power;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'boolean')]
    private bool $isManualGear = false;

    #[ORM\OneToMany(mappedBy: 'camper', targetEntity: Order::class)]
    private ArrayCollection $orders;

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
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return Camper
     */
    public function setBrand(string $brand): Camper
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return Camper
     */
    public function setModel(string $model): Camper
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @param int $power
     * @return Camper
     */
    public function setPower(int $power): Camper
    {
        $this->power = $power;
        return $this;
    }

    /**
     * @return bool
     */
    public function isManualGear(): bool
    {
        return $this->isManualGear;
    }

    /**
     * @param bool $isManualGear
     * @return Camper
     */
    public function setIsManualGear(bool $isManualGear): Camper
    {
        $this->isManualGear = $isManualGear;
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
            $order->setCamper($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCamper() === $this) {
                $order->setCamper(null);
            }
        }

        return $this;
    }
}

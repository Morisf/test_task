<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StationRepository::class)]
#[ORM\Table(name: 'stations')]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'startLocation', targetEntity: Order::class)]
    private Collection $orderStartLocation;

    #[ORM\OneToMany(mappedBy: 'startLocation', targetEntity: Order::class)]
    private Collection $orderEndLocation;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: LocationEquipment::class)]
    private Collection $localEquipment;

    #[ORM\Column(type: 'string', length: 2, nullable: false)]
    #[Assert\NotBlank]
    private string $countryCode;

    #[ORM\Column(type: 'string', length: 64, nullable: false)]
    #[Assert\NotBlank]
    private string $city;

    public function __construct()
    {
        $this->orderStartLocation = new ArrayCollection();
        $this->orderEndLocation = new ArrayCollection();
        $this->localEquipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return Station
     */
    public function setCountryCode(string $countryCode): Station
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Station
     */
    public function setCity(string $city): Station
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderStartLocation(): Collection
    {
        return $this->orderStartLocation;
    }

    public function addOrderStartLocation(Order $orderStartLocation): self
    {
        if (!$this->orderStartLocation->contains($orderStartLocation)) {
            $this->orderStartLocation[] = $orderStartLocation;
            $orderStartLocation->setStartLocation($this);
        }

        return $this;
    }

    public function removeOrderStartLocation(Order $orderStartLocation): self
    {
        if ($this->orderStartLocation->removeElement($orderStartLocation)) {
            // set the owning side to null (unless already changed)
            if ($orderStartLocation->getStartLocation() === $this) {
                $orderStartLocation->setStartLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderEndLocation(): Collection
    {
        return $this->orderEndLocation;
    }

    public function addOrderEndLocation(Order $orderEndLocation): self
    {
        if (!$this->orderEndLocation->contains($orderEndLocation)) {
            $this->orderEndLocation[] = $orderEndLocation;
            $orderEndLocation->setEndLocation($this);
        }

        return $this;
    }

    public function removeOrderEndLocation(Order $orderEndLocation): self
    {
        // set the owning side to null (unless already changed)
        if (
            $this->orderEndLocation->removeElement($orderEndLocation) &&
            $orderEndLocation->getEndLocation() === $this
        ) {
                $orderEndLocation->setEndLocation(null);
            }

        return $this;
    }

    /**
     * @return Collection<int, LocationEquipment>
     */
    public function getLocalEquipment(): Collection
    {
        return $this->localEquipment;
    }

    public function addLocalEquipment(LocationEquipment $localEquipment): self
    {
        if (!$this->localEquipment->contains($localEquipment)) {
            $this->localEquipment[] = $localEquipment;
            $localEquipment->setLocation($this);
        }

        return $this;
    }

    public function removeLocalEquipment(LocationEquipment $localEquipment): self
    {
        if ($this->localEquipment->removeElement($localEquipment)) {
            // set the owning side to null (unless already changed)
            if ($localEquipment->getLocation() === $this) {
                $localEquipment->setLocation(null);
            }
        }

        return $this;
    }
}

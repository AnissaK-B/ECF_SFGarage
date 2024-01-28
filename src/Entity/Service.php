<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceEmployee::class)]
    private Collection $serviceEmployees;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: User::class)]
    private Collection $user;

    public function __construct()
    {
        $this->serviceEmployees = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ServiceEmployee>
     */
    public function getServiceEmployees(): Collection
    {
        return $this->serviceEmployees;
    }

    public function addServiceEmployee(ServiceEmployee $serviceEmployee): static
    {
        if (!$this->serviceEmployees->contains($serviceEmployee)) {
            $this->serviceEmployees->add($serviceEmployee);
            $serviceEmployee->setService($this);
        }

        return $this;
    }

    public function removeServiceEmployee(ServiceEmployee $serviceEmployee): static
    {
        if ($this->serviceEmployees->removeElement($serviceEmployee)) {
            // set the owning side to null (unless already changed)
            if ($serviceEmployee->getService() === $this) {
                $serviceEmployee->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setService($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getService() === $this) {
                $user->setService(null);
            }
        }

        return $this;
    }
}

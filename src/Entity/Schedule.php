<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dayOfWeek = null;

    #[ORM\Column(length: 255)]
    private ?string $morningHours = null;

    #[ORM\Column(length: 255)]
    private ?string $eveningHours = null;

    #[ORM\ManyToOne(inversedBy: 'schedule')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(string $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getMorningHours(): ?string
    {
        return $this->morningHours;
    }

    public function setMorningHours(string $morningHours): static
    {
        $this->morningHours= $morningHours;
    
        return $this;
    }

    public function getEveningHours(): ?string
    {
        return $this->eveningHours;
    }

    public function setEveningHours(string $eveningHours): static
    {
        $this->eveningHours = $eveningHours;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

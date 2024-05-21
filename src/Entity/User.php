<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    #[Assert\PasswordStrength([
        'minScore' => PasswordStrength::STRENGTH_WEAK,
        'message' => 'Votre mot de passe est trop faible, il doit contenir des lettres, des chiffres et des caractères spéciaux'
    ])]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Schedule::class)]
    private Collection $schedule;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Testimonials::class)]
    private Collection $testimonials;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Service::class)]
    private Collection $service;

    public function __construct()
    {
        $this->schedule = new ArrayCollection();
        $this->testimonials = new ArrayCollection();
        $this->service = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Effacer les données sensibles, si nécessaire
    }

    public function getSchedule(): Collection
    {
        return $this->schedule;
    }

    public function addSchedule(Schedule $schedule): static
    {
        if (!$this->schedule->contains($schedule)) {
            $this->schedule->add($schedule);
            $schedule->setUser($this);
        }
        return $this;
    }

    public function removeSchedule(Schedule $schedule): static
    {
        if ($this->schedule->removeElement($schedule)) {
            if ($schedule->getUser() === $this) {
                $schedule->setUser(null);
            }
        }
        return $this;
    }

    public function getTestimonials(): Collection
    {
        return $this->testimonials;
    }

    public function addTestimonial(Testimonials $testimonials): static
    {
        if (!$this->testimonials->contains($testimonials)) {
            $this->testimonials->add($testimonials);
            $testimonials->setUser($this);
        }
        return $this;
    }

    public function removeTestimonial(Testimonials $testimonials): static
    {
        if ($this->testimonials->removeElement($testimonials)) {
            if ($testimonials->getUser() === $this) {
                $testimonials->setUser(null);
            }
        }
        return $this;
    }

    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): static
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
            $service->setUser($this);
        }
        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->service->removeElement($service)) {
            if ($service->getUser() === $this) {
                $service->setUser(null);
            }
        }
        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\UserRepository;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User implements UserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public ?int $id = null;

    /**
     * @ORM\Column(type="string")
     */
    public ?string $firstName = null;

    /**
     * @ORM\Column(type="string")
     */
    public ?string $lastName = null;

    public ?string $plainPassword = null;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", length=190, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public ?string $email = null;

    /**
     * @ORM\Column(type="string")
     */
    public ?string $jobTitle = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="users")
     */
    public ?Company $company = null;

    /**
     * @ORM\Column(type="array")
     */
    private array $roles = [self::ROLE_USER];

    /**
     * @ORM\Column(type="array")
     */
    public array $preferences = [];

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Shift", inversedBy="users")
     */
    private Collection $shifts;

    public function __construct()
    {
        $this->shifts = new ArrayCollection();
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = '';
    }

    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    public function setShifts(array $shifts): void
    {
        foreach ($shifts as $shift) {
            $this->addShift($shift);
        }
    }

    public function addShift(Shift $shift): void
    {
        $this->shifts->add($shift);
    }
}

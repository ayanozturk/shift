<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 *
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $firstName = '';

    /**
     * @ORM\Column(type="string")
     */
    public string $lastName = '';

    /**
     * @ORM\Column(type="string", length=100)
     */
    public string $password;

    /**
     * @ORM\Column(type="string", length=190, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email = '';

    /**
     * @ORM\Column(type="array")
     */
    private array $roles = [];

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }
}

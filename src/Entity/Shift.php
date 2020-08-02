<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShiftRepository;
use DateTime;

/**
 * Class Shift
 * @ORM\Entity(repositoryClass=ShiftRepository::class)
 */
class Shift
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $startDate = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $endDate = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="shifts")
     */
    private Collection $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="shifts")
     */
    public ?Company $company = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->startDate = new DateTime();
        $this->endDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User[] $users
     */
    public function setUsers(array $users): void
    {
        foreach ($users as $user) {
            $this->addUser($user);
        }
    }

    public function addUser(User $user): void
    {
        $this->users->add($user);
    }
}

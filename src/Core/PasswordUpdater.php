<?php

namespace App\Core;

use App\Core\Exception\InvalidCurrentPasswordException;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class PasswordUpdater
 */
class PasswordUpdater
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function updatePassword(User $user, string $currentPassword, string $newPassword): void
    {
        $checkPass = $this->passwordEncoder->isPasswordValid($user, $currentPassword);

        if (!$checkPass) {
            throw new InvalidCurrentPasswordException('Provided current password is invalid');
        }

        $this->encodeUserPassword($user, $newPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function encodeUserPassword(User $user, string $plainPassword): User
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));
        $user->eraseCredentials();

        return $user;
    }
}

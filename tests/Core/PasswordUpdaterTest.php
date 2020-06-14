<?php

namespace App\Tests\Core;

use App\Core\PasswordUpdater;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordUpdaterTest extends TestCase
{
    private PasswordUpdater $service;

    /**
     * @var MockObject|UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var EntityManagerInterface|MockObject
     */
    private $entityManager;

    protected function setUp(): void
    {
        $this->encoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)->getMock();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
        $this->service = new PasswordUpdater($this->encoder, $this->entityManager);
    }

    /**
     * @test
     */
    public function updatePassword(): void
    {
        $this->encoder->expects($this->once())
            ->method('encodePassword')
            ->willReturn('bar');

        $user = new User();
        $this->service->encodeUserPassword($user, 'foo');

        $this->assertSame('bar', $user->getPassword());
    }

    private function currentPasswordIsValid(bool $returnValue = true): void
    {
        $this->encoder->expects($this->once())->method('isPasswordValid')->willReturn($returnValue);
    }
}

<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{

    private EntityManager $entityManager;
    private UserRepository|null $userRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->userRepository = $this->entityManager
            ->getRepository(User::class);
    }

    public function testAddUser()
    {
        $user = new User();
        $user->setUsername('toto');
        $user->setEmail('toto@toto.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('toto');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertEquals('toto', $user->getUserIdentifier());
        $this->assertEquals('toto', $user->getPassword());
        $this->assertEquals('toto@toto.com', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testEditPassword()
    {
        $totoUser = $this->userRepository->findOneByUsername('toto');
        $this->userRepository->upgradePassword($totoUser, 'tata');

        $this->assertInstanceOf(User::class, $totoUser);
        $this->assertEquals('tata', $totoUser->getPassword());
    }
}

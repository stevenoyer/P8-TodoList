<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;

class UserEntity extends \PHPUnit\Framework\TestCase
{

    public function testUserEntity()
    {
        $task = new Task;

        $user = new User;
        $user->setUsername('anonymous');
        $user->setEmail('anonymous@email.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('loremipsum');

        $this->assertNotEmpty($user->getUserIdentifier());
        $this->assertNotEmpty($user->getUsername());
        $this->assertNotEmpty($user->getEmail());
        $this->assertNotEmpty($user->getRoles());
        $this->assertIsArray($user->getRoles());

        $this->assertEquals('anonymous', $user->getUsername());
        $this->assertEquals('anonymous@email.com', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals('loremipsum', $user->getPassword());
        $this->assertEquals(null, $user->getSalt());
    }
}

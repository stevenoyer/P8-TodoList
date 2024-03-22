<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class UserEntity extends \PHPUnit\Framework\TestCase
{

    public function testUserEntity()
    {
        $task = new Task;
        $task->setContent('Contenu de test');
        $task->setTitle('Hello!');
        $task->toggle(true);

        $user = new User;
        $user->setUsername('anonymous');
        $user->setEmail('anonymous@email.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('loremipsum');
        $user->addTask($task);

        $this->assertNotEmpty($user->getUserIdentifier());
        $this->assertNotEmpty($user->getUsername());
        $this->assertNotEmpty($user->getEmail());
        $this->assertNotEmpty($user->getRoles());
        $this->assertIsArray($user->getRoles());

        $this->assertEquals('anonymous', $user->getUsername());
        $this->assertEquals('anonymous@email.com', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals('loremipsum', $user->getPassword());
        $this->assertEquals('Hello!', $task->getTitle());
        $this->assertEquals(null, $user->getSalt());
    }
}

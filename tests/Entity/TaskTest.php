<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use DateTime;

class TaskEntity extends \PHPUnit\Framework\TestCase
{

    public function testTaskEntity()
    {
        $user = new User;
        $date = new DateTime('now');

        $task = new Task;
        $task->setTitle('Un titre');
        $task->setContent('Je suis un test');
        $task->setCreatedAt($date);
        $task->setUser($user);
        $task->toggle(false);

        $this->assertNotEmpty($task->getTitle());
        $this->assertNotEmpty($task->getContent());
        $this->assertIsBool($task->isDone());

        $this->assertEquals('Un titre', $task->getTitle());
        $this->assertEquals('Je suis un test', $task->getContent());
        $this->assertEquals($date, $task->getCreatedAt());
        $this->assertEquals(false, $task->isDone());
        $this->assertEquals($user, $task->getUser());
    }
}

<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
    private EntityManager $entityManager;
    private UserRepository|null $userRepository;
    private TaskRepository|null $taskRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->userRepository = $this->entityManager
            ->getRepository(User::class);

        $this->taskRepository = $this->entityManager
            ->getRepository(Task::class);
    }

    /**
     * Test: save task
     */
    public function testSaveTask(): void
    {
        $testUser = $this->userRepository->findOneByUsername('test');

        $task = new Task;
        $task->setTitle('Test title');
        $task->setContent('Test Content');
        $dateNow = new DateTime();
        $task->setCreatedAt($dateNow);
        $task->toggle(true);
        $task->setUser($testUser);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $this->assertEquals('Test title', $task->getTitle());
        $this->assertEquals('Test Content', $task->getContent());
        $this->assertEquals($dateNow, $task->getCreatedAt());
        $this->assertEquals(true, $task->isDone());
    }

    /**
     * Test: Remove Task
     */
    public function testRemoveTask(): void
    {
        self::bootKernel();

        $testUser = $this->userRepository->findOneByUsername('test');
        $task = $this->taskRepository->findOneBy(['user' => $testUser]);
        $taskId = $task->getId();
        $this->assertInstanceOf(Task::class, $task);

        $this->taskRepository->remove($task);

        $this->assertNull($this->taskRepository->find($taskId));
    }
}

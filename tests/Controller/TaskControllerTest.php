<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{

    private KernelBrowser|null $client = null;
    private UserRepository|null $userRepository;
    private TaskRepository|null $taskRepository;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->taskRepository = $this->client->getContainer()->get(TaskRepository::class);
        $this->userRepository = $this->client->getContainer()->get(UserRepository::class);

        $testUser = $this->userRepository->findOneBy(['email' => 'test@todolist.com']);
        $this->client->loginUser($testUser);

        $this->client->followRedirects();
    }

    /**
     * Test: Task list.
     */
    public function testListAction()
    {
        $this->client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Liste des tâches');
    }

    /**
     * Test: Return to task list from task creation.
     */
    public function testBackToTaskListFromTaskCreate()
    {
        $crawler = $this->client->request('GET', '/tasks/create');
        $link = $crawler->selectLink('Retour à la liste des tâches')->link();
        $this->client->click($link);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h2', 'Liste des tâches');
    }

    /**
     * Test: Creation of Task Successful.
     */
    public function testCreateActionWorked()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche de test';
        $form['task[content]'] = 'Un contenu de test';
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'La tâche a été bien été ajoutée'
        );
    }

    /**
     * Test: Create of Task Not Working.
     */
    public function testCreateActionDontWorking()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche qui ne fonctionne pas';
        $form['task[content]'] = '';
        $this->client->submit($form);

        $this->assertSelectorNotExists(
            'div.alert.alert-success',
            'La tâche a été bien été ajoutée'
        );
    }

    /**
     * Test: Edit Task
     */
    public function testEditAction()
    {
        $testUser = $this->userRepository->findOneByUsername('test');
        $task = $this->taskRepository->findOneBy(['user' => $testUser->getId()]);

        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Modification de la tâche pour test';
        $form['task[content]'] = 'Un contenu de test de modification';
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'Superbe ! La tâche a bien été modifiée.'
        );
    }

    /**
     * Test: Is Task Edit Prohibited for User
     */
    public function testIsTaskEditProhibitedForUser()
    {
        $testUser = $this->userRepository->findOneByUsername('test');
        $this->client->loginUser($testUser);

        $anonymeUser = $this->userRepository->findOneByUsername('anonymous');
        $task = $this->taskRepository->findOneBy(['user' => $anonymeUser->getId()]);

        $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');
        $this->assertSelectorTextContains(
            'div.alert.alert-danger',
            'Vous n\'êtes pas l\'auteur de cette tâche'
        );
    }

    /**
     * Test: Toggle Task Action Is Done
     */
    public function testToggleTaskActionIsDone()
    {
        $testUser = $this->userRepository->findOneByUsername('test');
        $task = $this->taskRepository->findOneBy(['user' => $testUser->getId(), 'isDone' => 0]);

        $taskBeforeIsDone = $task->isDone();
        $this->client->request('GET', '/tasks/' . $task->getId() . '/toggle');
        $taskAferIsDone = $task->isDone();

        $this->assertNotSame($taskBeforeIsDone, $taskAferIsDone);
        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'Superbe ! La tâche ' . $task->getTitle() . ' a bien été marquée comme faite.'
        );
    }

    /**
     * Test: Toggle Task Action Is Todo
     */
    public function testToggleTaskActionIsTodo()
    {
        $testUser = $this->userRepository->findOneByUsername('test');
        $task = $this->taskRepository->findOneBy(['user' => $testUser->getId(), 'isDone' => 1]);

        $taskBeforeIsDone = $task->isDone();
        $this->client->request('GET', '/tasks/' . $task->getId() . '/toggle');
        $taskAferIsDone = $task->isDone();

        $this->assertNotSame($taskBeforeIsDone, $taskAferIsDone);
        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'Superbe ! La tâche ' . $task->getTitle() . ' a bien été marquée comme non terminée.'
        );
    }

    /**
     * Test: Is Task Toggle Prohibited for User
     */
    public function testIsTaskToggleProhibitedForUser()
    {
        $testUser = $this->userRepository->findOneByUsername('test');
        $this->client->loginUser($testUser);

        $anonymeUser = $this->userRepository->findOneByUsername('anonymous');
        $task = $this->taskRepository->findOneBy(['user' => $anonymeUser->getId()]);
        $this->client->request('GET', '/tasks/' . $task->getId() . '/toggle');

        $this->assertSelectorTextContains(
            'div.alert.alert-danger',
            'Oops ! Vous n\'êtes pas l\'auteur de cette tâche.'
        );
    }

    /**
     * Test: Delete Task Action
     */
    public function testDeleteTaskAction(): void
    {
        $testUser = $this->userRepository->findOneByUsername('test');
        $task = $this->taskRepository->findOneBy(['user' => $testUser->getId()]);
        $this->client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'La tâche a bien été supprimée.'
        );
    }

    /**
     * Test: Delete Task Prohibited for User
     */
    public function testDeleteTaskIsProhibitedForThisUser(): void
    {
        $testRegisteredUser = $this->userRepository->findOneByUsername('test');
        $this->client->loginUser($testRegisteredUser);

        $anonymeUser = $this->userRepository->findOneByUsername('anonymous');
        $task = $this->taskRepository->findOneBy(['user' => $anonymeUser->getId()]);
        $this->client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $this->assertSelectorTextContains(
            'div.alert.alert-danger',
            'Oops ! Vous n\'êtes pas l\'auteur de cette tâche.'
        );
    }

    /**
     * Test: Anonymous Deletion of Task by Admin
     */
    public function testAnonymousDeleteTaskActionByAdmin(): void
    {
        $adminUser = $this->userRepository->findOneByUsername('admin');
        $this->client->loginUser($adminUser);

        $anonymeUser = $this->userRepository->findOneByUsername('anonymous');
        $task = $this->taskRepository->findOneBy(['user' =>  $anonymeUser->getId()]);
        $this->client->request('GET', '/tasks/' . $task->getId() . '/delete');

        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'La tâche a bien été supprimée.'
        );
    }
}

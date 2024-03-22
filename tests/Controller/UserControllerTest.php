<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    private KernelBrowser|null $client = null;
    private UserRepository|null $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->userRepository = $this->client->getContainer()->get(UserRepository::class);
        $admin = $this->userRepository->findOneByUsername('admin');

        $this->client->loginUser($admin);
        $this->client->followRedirects();
    }

    /**
     * Test: List Users
     */
    public function testListAction()
    {
        $this->client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('h2', 'Liste des utilisateurs');
    }

    /**
     * Test: Create User
     */
    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'testuser';
        $form['user[email]'] = 'testuser@test.com';
        $form['user[roles]'] = "ROLE_USER";
        $form['user[password][first]'] = 'toto';
        $form['user[password][second]'] = 'toto';

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success', 'L\'utilisateur a bien été ajouté.');
    }

    /**
     * Test: Edit User
     */
    public function testEditAction()
    {
        $testUser = $this->userRepository->findOneByUsername('testuser');
        $crawler = $this->client->request('GET', '/users/' . $testUser->getId() . '/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'testuser_modified';
        $form['user[email]'] = 'testuser@modified.com';
        $form['user[roles]'] = "ROLE_USER";
        $form['user[password][first]'] = 'modified';
        $form['user[password][second]'] = 'modified';

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success', 'L\'utilisateur a bien été modifié');
    }
}

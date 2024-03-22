<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testIndexAction(): void
    {
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['email' => 'test@todolist.com']);

        $this->client->loginUser($testUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('homepage'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
    }
}

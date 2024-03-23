<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    /**
     * Test: Display Login
     */
    public function testDisplayLogin(): void
    {
        $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('input[id="username"]');
        $this->assertSelectorExists('input[id="password"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    /**
     * Test: Login with Correct Credentials
     */
    public function testLoginWithGoodCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'test',
            '_password' => 'test'
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.btn-danger', 'Se déconnecter');
    }

    /**
     * Test: Login with Incorrect Credentials
     */
    public function testLoginWithBadCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'test',
            '_password' => 'nopassword'
        ]);

        $this->client->submit($form);

        $this->assertSelectorExists('div.alert.alert-danger');
    }

    /**
     * Test: Logout
     */
    public function testLogout()
    {
        $this->client->request('GET', '/logout');
        $this->assertSelectorExists('label', 'Nom d\'utilisateur :');
        $this->assertSelectorExists('label', 'Mot de passe :');
    }
}

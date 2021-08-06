<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testList(): void
    {
        // Crée un client HTTP
        $client = static::createClient();
        // Envoie une requête vers l'url '/'
        $crawler = $client->request('GET', '/');

        // Est-ce que la réponse a un statut 2xx
        $this->assertResponseIsSuccessful();
        // Est-ce que je suis bien sur la page d'accueil
        $this->assertSelectorTextContains('h1', 'Tous les films');
    }

    /**
     * L'anonyme n'a pas accès à l'écriture d'une Review
     * et se trouve redirigé
     */
    public function testReviewAddFailure()
    {
        // Crée un client HTTP
        $client = static::createClient();
        // Envoie une requête vers l'url '/'
        $crawler = $client->request('GET', '/review/add/the-parent-trap');

        $this->assertResponseRedirects();
        // Est-ce que je suis bien sur la page d'accueil
    }

    /**
     * Test movie show
     */
    public function testMovieShow(): void
    {
        // Crée un client HTTP
        $client = static::createClient();
        // Envoie une requête vers l'url '/'
        $crawler = $client->request('GET', '/');

        // Sélectionner le premier lien de la liste des films
        $selectedLink = $crawler->filter('.movie-main p a');
        $textLink = $selectedLink->text();
        $link = $selectedLink->link();

        // Cliquer dessus
        $client->click($link);

        // Vérifier que la réponse est successful
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextSame('h1#header-margin', $textLink);

    }

}

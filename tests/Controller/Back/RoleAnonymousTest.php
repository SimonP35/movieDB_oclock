<?php

namespace App\Tests\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Teste les redirection pour le user anonyme
 */
class RoleAnonymousTest extends WebTestCase
{
    /**
     * List
     * 
     * @dataProvider backendUrlsProvider
     */
    public function testList($method, $url): void
    {
        $client = static::createClient();
        $crawler = $client->request($method, $url);

        $this->assertResponseRedirects();
    }

    public function backendUrlsProvider()
    {
        // Movie
        yield ['GET', '/back/movie/list'];
        yield ['GET', '/back/movie/edit/1'];
        yield ['POST', '/back/movie/edit/1'];
        yield ['GET', '/back/movie/add'];
        yield ['POST', '/back/movie/add'];
        yield ['POST', '/back/movie/delete/1'];
        // User
        yield ['GET', '/back/user/list'];
        yield ['GET', '/back/user/edit/1'];
        yield ['POST', '/back/user/edit/1'];
        yield ['GET', '/back/user/add'];
        yield ['POST', '/back/user/add'];
        yield ['POST', '/back/user/delete/1'];
        // Job
        yield ['GET', '/back/job/list'];
        yield ['GET', '/back/job/edit/1'];
        yield ['POST', '/back/job/edit/1'];
        yield ['GET', '/back/job/add'];
        yield ['POST', '/back/job/add'];
        yield ['POST', '/back/job/delete/1'];
    }

    //? Code JC :
    
    // /**
    //  * Browse
    //  */
    // public function testBrowse(): void
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/back/movie/browse');

    //     $this->assertResponseRedirects();
    // }

    // /**
    //  * Read
    //  */
    // public function testRead(): void
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/back/movie/read/1');

    //     $this->assertResponseRedirects();
    // }

}

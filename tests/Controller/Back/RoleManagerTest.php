<?php

namespace App\Tests\Controller\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Teste les accès pour le ROLE_MANAGER
 */
class RoleManagerTest extends WebTestCase
{
    /**
     * Access OK (200)
     * 
     * @dataProvider hasAccessUrls
     */
    public function testHasAccess($url): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('manager@manager.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        
        $crawler = $client->request('GET', '/back/movie/list');

        $this->assertResponseIsSuccessful();
    }

    public function hasAccessUrls()
    {
        yield ['GET', '/back/movie/list'];
        yield ['GET', '/back/movie/read/1'];
    }

    /**
     * Access Denied (403)
     * 
     * @dataProvider accessDeniedUrls
     */
    public function testAdd(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('manager@manager.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/movie/add');

        $this->assertResponseStatusCodeSame(403);
    }

    public function accessDeniedUrls()
    {
        // Movie
        yield ['GET', '/back/movie/edit/1'];
        yield ['POST', '/back/movie/edit/1'];
        yield ['GET', '/back/movie/add'];
        yield ['POST', '/back/movie/add'];
        yield ['POST', '/back/movie/delete/1'];
    }

}

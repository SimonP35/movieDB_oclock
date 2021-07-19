<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Movie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 5 Movies
        for ($i = 0; $i < 5; $i++) 
        {
            $movie = new Movie();

            $movie
            ->setTitle('title' . $i)
            ->setDuration(mt_rand(90, 200))
            ->setReleaseDate(new DateTime("".mt_rand(1900, 2020)."-".mt_rand(1, 12)."-".mt_rand(1, 31)." 00:00:00"))
            ->setCreatedAt(new DateTime());

            $manager->persist($movie);
            $manager->flush();
        }

    }
}

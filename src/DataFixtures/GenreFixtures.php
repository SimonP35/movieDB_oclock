<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 5 Genres
        for ($i = 0; $i < 5; $i++) 
        {
            $genre = new Genre();

            $genre
            ->setName('name' . $i);

            $manager->persist($genre);
            $manager->flush();
        }

    }
}

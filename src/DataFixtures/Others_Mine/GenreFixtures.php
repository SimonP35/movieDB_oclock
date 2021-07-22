<?php

namespace App\DataFixtures\Others_Mine;

use Faker\Factory;
use App\Entity\Genre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GenreFixtures extends Fixture
{
    // public const GENRE_REFERENCE = 'genre';

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();

        // Create 10 Genres
        for ($i = 0; $i <= 10; $i++) 
        {
            $genre = new Genre();

            $genre
            ->setName($faker->word());

            $manager->persist($genre);
            $this->addReference('genre_'.$i, $genre);  
        }
        
        $manager->flush();
    }
}

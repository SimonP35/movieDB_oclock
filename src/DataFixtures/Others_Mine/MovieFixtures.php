<?php

// namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Movie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    // public const MOVIE_REFERENCE = 'movie';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create 25 Movies
        for ($i = 0; $i <= 25; $i++) 
        {
            $movie = new Movie();

            $nbGenre = mt_rand(1, 2);

            $movie
            ->setTitle($faker->unique->city())
            ->setDuration($faker->numberBetween(90, 220))
            ->setReleaseDate($faker->dateTimeBetween())
            ->setCreatedAt(new DateTime());

            $nbGenre === 2 ?

            $movie 
            ->addGenre($this->getReference('genre_'.mt_rand(0, 10)))
            ->addGenre($this->getReference('genre_'.mt_rand(0, 10))):

            // Sinon
            $movie
            ->addGenre($this->getReference('genre_'.mt_rand(0, 10)));

            $manager->persist($movie);
            $this->addReference('movie_'.$i, $movie);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            GenreFixtures::class,
        ];
    }

}

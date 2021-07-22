<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Casting;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\MovieDbProvider;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Si on veut toujours les mêmes données on plante une "graine" (seed)
        // $faker->seed('datasNameHere');

        // Notre fournisseur de données, ajouté à Faker
        $faker->addProvider(new MovieDbProvider());

        // Notre fournisseur de données
        // $movieDbProvider = new MovieDbProvider();

        $genresList = [];

        // 20 genres
        for ($i = 1; $i <= 20; $i++) {

            $genre = new Genre();
            $genre->setName($faker->unique->movieGenre());

            $genresList[] = $genre;

            $manager->persist($genre);
        }
        
        $moviesList = [];

        // 50 films
        for ($i = 1; $i <= 50; $i++) {

            $nbGenre = mt_rand(1, 3);

            $movie = new Movie();
            $movie->setTitle($faker->unique->movieTitle());
            $movie->setCreatedAt(new DateTime());
            $movie->setDuration($faker->numberBetween(90, 220));
            $movie->setPoster($faker->imageUrl(300, 400));
            $movie->setRating($faker->numberBetween(1, 5));
            $movie->setReleaseDate($faker->dateTimeBetween());

            // Association de 1 à 3 genres au hasard
            for ($index = 1; $index <= $nbGenre; $index++) {
                // https://www.php.net/manual/fr/function.array-rand.php
                // On va chercher un index au hasard (array_rand)
                // dans le taleau des genres
                $movie->addGenre($genresList[array_rand($genresList)]);
            }

            $moviesList[] = $movie;

            $manager->persist($movie);
        }

        $personsList = [];

        // 20 personnes
        for ($i = 1; $i <= 30; $i++) {

            $person = new Person();
            $person->setFirstname($faker->firstname());
            $person->setLastname($faker->unique->lastname());

            $personsList[] = $person;

            $manager->persist($person);
        }

        // 100 castings
        for ($i = 1; $i <= 100; $i++) {

            $casting = new Casting();
            $casting->setRole($faker->movieJobName());
            $casting->setCreditOrder($faker->numberBetween(1, 10));

            // Variante avec mt_rand et count
            $randomMovie = $moviesList[mt_rand(0, count($moviesList) - 1)];
            $casting->setMovie($randomMovie);

            // Variante avec array_rand()
            $randomPerson = $personsList[array_rand($personsList)];
            $casting->setPerson($randomPerson);

            $manager->persist($casting);
        }
               
        $manager->flush();
    }
    
}

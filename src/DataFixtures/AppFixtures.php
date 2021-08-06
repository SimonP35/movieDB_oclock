<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Job;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Review;
use App\Entity\Casting;
use App\Entity\Department;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\MovieDbProvider;
use App\Service\OmdbApi;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\SlugService;
use Doctrine\DBAL\Connection;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    private $slugService;

    private $omdbApi;

    private $co;

    public function __construct(UserPasswordHasherInterface $passwordHasher, SlugService $slugService, OmdbApi $omdbApi, Connection $co)
    {
        $this->passwordHasher = $passwordHasher;
        $this->slugService = $slugService;
        $this->omdbApi = $omdbApi;
        $this->co = $co;
    }

    private function truncate()
    {
        // On passen mode SQL ! On cause avec MySQL
        // Désactivation des contraintes FK
        $this->co->executeQuery('SET foreign_key_checks = 0');
        // On tronque
        $this->co->executeQuery('TRUNCATE TABLE casting');
        $this->co->executeQuery('TRUNCATE TABLE department');
        $this->co->executeQuery('TRUNCATE TABLE genre');
        $this->co->executeQuery('TRUNCATE TABLE job');
        $this->co->executeQuery('TRUNCATE TABLE movie');
        $this->co->executeQuery('TRUNCATE TABLE movie_genre');
        $this->co->executeQuery('TRUNCATE TABLE person');
        $this->co->executeQuery('TRUNCATE TABLE review');
        $this->co->executeQuery('TRUNCATE TABLE team');
        $this->co->executeQuery('TRUNCATE TABLE user');
    }

    public function load(ObjectManager $manager)
    {
        $this->truncate();

        $faker = Factory::create('fr_FR');

        // Notre fournisseur de données, ajouté à Faker
        $faker->addProvider(new MovieDbProvider());

        // 3 users "en dur" : USER, MANAGER, ADMIN
        // mot de passe = user, manager, admin
        $user = new User();
        $user->setEmail('user@user.com');
        // user via "bin/console security:hash-password"
        $user->setPassword('$2y$13$h.eZWrS5PJya7zNMNsKcXe8LUSVBtN2PBy8WHxmdHgAFjHG/rW.dG');
        $user->setRoles(['ROLE_USER']);

        $userManager = new User();
        $userManager->setEmail('manager@manager.com');
        // manager via "bin/console security:hash-password"
        $userManager->setPassword('$2y$13$3YxSfXMdyaKdplTEd07.SuDnbjAQZIAn8NLbhHzTLUnl1N7oegQg2');
        $userManager->setRoles(['ROLE_MANAGER']);

        $admin = new User();
        $admin->setEmail('admin@admin.com');
        // admin via "bin/console security:hash-password"
        $admin->setPassword('$2y$13$L81zK/fTjQikyz3PtBmbL.WdDILXR.Ppn.whBAvLJsbaFu4Fu0zVe');
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->persist($userManager);
        $manager->persist($admin);

        for ($i = 1; $i <= 15; $i++ ) {

            $rolesList = [];
            $rolesList[] = $faker->roleName();

            $user = new User();
            $user
            ->setEmail($faker->unique->email())
            ->setPassword($this->passwordHasher->hashPassword(
                $user, $faker->unique->password()
            ))
            ->setRoles($rolesList);
    
            $manager->persist($user);
    
        }

        // Notre fournisseur de données
        // $movieDbProvider = new MovieDbProvider();

        $genresList = [];

        // 20 genres
        for ($i = 1; $i <= 20; $i++) {

            $genre = new Genre();
            $genre
            ->setName($faker->unique->movieGenre())
            // Fonctionne avec la mise en place de la méthode __toString()
            ->setSlug($this->slugService->toSlug($genre));;

            $genresList[] = $genre;

            $manager->persist($genre);
        }
        
        $moviesList = [];

        // 50 films
        for ($i = 1; $i <= 50; $i++) {

            $nbGenres = mt_rand(1, 3);
            // $randomImageType = $faker->imageTypesName();

            $movie = new Movie();

            $movie
            ->setTitle($faker->unique->movieTitle())
            ->setDuration($faker->numberBetween(90, 220))
            ->setPoster($this->omdbApi->fetchPoster($movie))
            // ->setPoster("http://lorempixel.com/300/400/$randomImageType")
            ->setRating($faker->numberBetween(1, 5))
            ->setReleaseDate($faker->dateTimeBetween())
            ->setSynopsis($faker->text(350));

            // Association de 1 à 3 genres au hasard
            for ($index = 1; $index <= $nbGenres; $index++) {
                // https://www.php.net/manual/fr/function.array-rand.php
                // On va chercher un index au hasard (array_rand)
                // dans le taleau des genres
                $movie->addGenre($genresList[array_rand($genresList)]);
            }

            $moviesList[] = $movie;

            $manager->persist($movie);
        }

        // 100 reviews
        for ($i = 1; $i <= 100; $i++) {

            $reactionList = [];

            $nbReactions = mt_rand(0, 5);

            $review = new Review();

            $review
            ->setUsername($faker->name())
            ->setEmail($faker->email())
            ->setContent($faker->paragraph())
            ->setRating($faker->numberBetween(1, 5))
            ->setPublishedAt(new DateTime())
            ->setWatchedAt($faker->dateTimeBetween());

            // Association de 0 à 5 reactions au hasard
            for ($index = 1; $index <= $nbReactions; $index++) {

                $reaction = $faker->reactionName();
                $reactionList[] = $reaction;
            }

            $review->setReactions($reactionList);
            $reactionList = [];

            $review->setMovie($moviesList[array_rand($moviesList)]);

            $manager->persist($review);
        }

        $personsList = [];

        // 20 personnes
        for ($i = 1; $i <= 30; $i++) {

            $person = new Person();
            $person
            ->setFirstname($faker->firstname())
            ->setLastname($faker->unique->lastname());

            $personsList[] = $person;

            $manager->persist($person);
        }

        // 100 castings
        for ($i = 1; $i <= 100; $i++) {

            $casting = new Casting();

            $casting
            ->setRole($faker->movieJobName())
            ->setCreditOrder($faker->numberBetween(1, 10));

            // Variante avec mt_rand et count
            $randomMovie = $moviesList[mt_rand(0, count($moviesList) - 1)];
            $casting->setMovie($randomMovie);

            // Variante avec array_rand()
            $randomPerson = $personsList[array_rand($personsList)];
            $casting->setPerson($randomPerson);

            $manager->persist($casting);
        }

        $departmentsList = [];

        // 20 departments
        for ($i = 1; $i <= 20; $i++) {

            $department = new Department();

            $department
            ->setName($faker->movieDepartmentName())
            ->setCreatedAt(new DateTime());

            $departmentsList[] = $department;

            $manager->persist($department);
        }
        
        // 30 jobs
        for ($i = 1; $i <= 30; $i++) {

            $job = new Job();
            $job->setName($faker->movieJobName());
            $job->setCreatedAt(new DateTime());

            // Variante avec array_rand()
            $randomDepartment = $departmentsList[array_rand($departmentsList)];
            $job->setDepartment($randomDepartment);

            $manager->persist($job);
        }
                 
        $manager->flush();
    }
    
}

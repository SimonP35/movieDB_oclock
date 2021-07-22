<?php

namespace App\DataFixtures\Others_Mine;

use Faker\Factory;
use App\Entity\Casting;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CastingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create 30 Castings
        for ($i = 0; $i <= 30; $i++) 
        {
            $casting = new Casting();

            $casting
            ->setRole($faker->jobTitle())
            ->setCreditOrder($faker->numberBetween(1, 5))
            ->setPerson($this->getReference('person_'.mt_rand(0, 20)))
            ->setMovie($this->getReference('movie_'.mt_rand(0, 20)));

            $manager->persist($casting);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            PersonFixtures::class,
            MovieFixtures::class
        ];
    }
}

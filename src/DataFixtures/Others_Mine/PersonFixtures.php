<?php

namespace App\DataFixtures\Others_Mine;

use Faker\Factory;
use App\Entity\Person;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create 20 Persons
        for ($i = 0; $i <= 20; $i++) {

            $person = new Person();

            $person
            ->setFirstname($faker->firstname())
            ->setLastname($faker->unique->lastname());

            $manager->persist($person);
            $this->addReference('person_'.$i , $person);
        }

        $manager->flush();
    }
}

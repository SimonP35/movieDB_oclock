<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Person;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 5 Persons
        for ($i = 0; $i < 5; $i++) 
        {
            $person = new Person();

            $person
            ->setFirstname('firstname' . $i)
            ->setLastname('lastname' . $i);

            $manager->persist($person);
            $manager->flush();
        }

    }
}

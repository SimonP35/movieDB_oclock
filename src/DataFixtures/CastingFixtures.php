<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Casting;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CastingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 5 Castings
        for ($i = 0; $i < 5; $i++) 
        {
            $casting = new Casting();

            $casting
            ->setRole('role' . $i)
            ->setCreditOrder('credit_order' . $i);

            $manager->persist($casting);
            $manager->flush();
        }

    }
}

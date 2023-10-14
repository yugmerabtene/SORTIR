<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $site = ["SAINT HERBLAIN", "CHARTRES DE BRETAGNE", "LA ROCHE SUR YON"];

        for ($i = 0; $i < 3; $i++) {
         $campus = new Campus();
         $campus->setNom($site[$i]);
         $manager->persist($campus);
        }

        $manager->flush();
    }
}

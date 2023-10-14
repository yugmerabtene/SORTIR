<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $etats = ["Créée",
            "Ouverte",
            "Cloturée",
            "Acitvité en cours",
            "Passée",
            "Annulée"];

        for ($i = 0; $i < 6; $i++) {
            $etat = new Etat();
            $etat->setLibelle($etats[$i]);
            $manager->persist($etat);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
        ];
    }
}
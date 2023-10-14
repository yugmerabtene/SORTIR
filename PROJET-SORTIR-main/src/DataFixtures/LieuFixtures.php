<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LieuFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $villes = $manager->getRepository(Ville::class)->findAll();

        foreach ($villes as $ville) {
            for ($i = 0; $i <= 5; $i++) {
                $lieu = new Lieu();
                $lieu->setNom($faker->city);
                $lieu->setRue($faker->streetAddress . $faker->streetName);
                $lieu->setLatitude($faker->latitude);
                $lieu->setLongitude($faker->longitude);
                $lieu->setVille($ville);

                $manager->persist($lieu);
            }
        }

        $manager->flush();
    }
}
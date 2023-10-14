<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listCampus = $manager->getRepository(Campus::class)->findAll();

        foreach ($listCampus as $campus) {
            for ($i = 0; $i < 10; $i++) {
                $participant = new Participant();
                $participant->setPassword($this->passwordHasher->hashPassword($participant, "azerty"));
                $participant->setNom($faker->name);
                $participant->setActif(true);
                $participant->setEmail($faker->email);
                $participant->setTelephone($faker->phoneNumber);
                $participant->setPrenom($faker->firstName);
                $participant->setCampus($campus);

                $manager->persist($participant);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampusFixtures::class,
        ];
    }
}
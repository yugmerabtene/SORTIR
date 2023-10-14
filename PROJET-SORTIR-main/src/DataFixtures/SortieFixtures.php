<?php

namespace App\DataFixtures;


use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $listCampus = $manager->getRepository(Campus::class)->findAll();
        $listEtat = $manager->getRepository(Etat::class)->findAll();
        $listLieu = $manager->getRepository(Lieu::class)->findAll();

        foreach ($listCampus as $campus) {
            for ($i = 0; $i < 5; $i++) {
                $sortie = new Sortie();
                $sortie->setNom($faker->title);
                $sortie->setDateHeureDebut($faker->dateTimeThisMonth);
                $sortie->setDuree($faker->numberBetween(0,600));
                $sortie->setDateLimiteInscription($faker->dateTimeBetween('-3 months', $sortie->getDateHeureDebut()));
                $sortie->setNbInscriptionMax($faker->numberBetween(3,5));
                $sortie->setInfosSortie("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.");
                $sortie->setCampus($campus);
                $sortie->setEtat($faker->randomElement($listEtat));

                // Participants
                $listParticipant = $manager->getRepository(Participant::class)->findBy(['campus' => $campus]);
                $sortie->setOrganisateur($faker->randomElement($listParticipant));

                for ($i = 0; $i < sizeof($listParticipant); $i++) {
                    $sortie->addParticipant($listParticipant[$i]);
                }

                // Lieu
                $sortie->setLieu($faker->randomElement($listLieu));

            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampusFixtures::class,
            ParticipantFixtures::class,
            EtatFixtures::class,
        ];
    }
}
<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Ce nom de sortie est trop court',maxMessage: 'Ce nom de sortie est trop long') ]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'datetime')]
    private $dateHeureDebut;

    #[Assert\NotBlank]
    #[Assert\Positive(message: "La durée de la sortie doit être supérieure à 0 minute")]
    #[ORM\Column(type: 'integer')]
    private $duree;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'date')]
    private $dateLimiteInscription;

    #[Assert\NotBlank]
    #[Assert\Positive(message: "Le nombre de places pour cette activité doit être supérieur à 0")]
    #[ORM\Column(type: 'integer')]
    private $nbInscriptionMax;

    #[Assert\NotBlank]
    #[Assert\Length(max: 4000,maxMessage: 'Cette description est trop longue') ]
    #[ORM\Column(type: 'text')]
    private $infosSortie;


    #[ORM\ManyToMany(targetEntity: Participant::class, mappedBy: 'sortiesInscrit')]
    private $participants;

    #[ORM\ManyToOne(targetEntity: Participant::class, inversedBy: 'sortiesOrganisateur')]
    #[ORM\JoinColumn(nullable: false)]
    private $organisateur;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;

    #[ORM\ManyToOne(targetEntity: Etat::class, inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private $etat;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private $lieu;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTime
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTime $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionMax(): ?int
    {
        return $this->nbInscriptionMax;
    }

    public function setNbInscriptionMax(int $nbInscriptionMax): self
    {
        $this->nbInscriptionMax = $nbInscriptionMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->addSortiesInscrit($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            $participant->removeSortiesInscrit($this);
        }

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }
}

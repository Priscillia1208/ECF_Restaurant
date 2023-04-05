<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    const ETAT_CONFIRME = 'CONFIRME';
    const ETAT_ANNULE = 'ANNULE';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEtHeureArrivee;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToMany(targetEntity=Table::class, inversedBy="reservations")
     */
    private $tables;

    /**
     * @ORM\ManyToMany(targetEntity=Allergene::class, mappedBy="reservations")
     */
    private $allergenes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nomClient;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbCouverts;

    public function __construct()
    {
        $this->tables = new ArrayCollection();
        $this->allergenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEtHeureArrivee(): ?\DateTimeInterface
    {
        return $this->dateEtHeureArrivee;
    }

    public function setDateEtHeureArrivee(\DateTimeInterface $dateEtHeureArrivee): self
    {
        $this->dateEtHeureArrivee = $dateEtHeureArrivee;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): self
    {
        if (!$this->tables->contains($table)) {
            $this->tables[] = $table;
        }

        return $this;
    }

    public function removeTable(Table $table): self
    {
        $this->tables->removeElement($table);

        return $this;
    }

    /**
     * @return Collection<int, Allergene>
     */
    public function getAllergenes(): Collection
    {
        return $this->allergenes;
    }

    public function addAllergene(Allergene $allergene): self
    {
        if (!$this->allergenes->contains($allergene)) {
            $this->allergenes[] = $allergene;
            $allergene->addReservation($this);
        }

        return $this;
    }

    public function removeAllergene(Allergene $allergene): self
    {
        if ($this->allergenes->removeElement($allergene)) {
            $allergene->removeReservation($this);
        }

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getNbCouverts(): ?int
    {
        return $this->nbCouverts;
    }

    public function setNbCouverts(int $nbCouverts): self
    {
        $this->nbCouverts = $nbCouverts;

        return $this;
    }
}

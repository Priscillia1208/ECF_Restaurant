<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoraireRepository::class)
 */
class Horaire
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $jourSemaine;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heureDebutMatin;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heureFinMatin;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heureDebutSoir;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heureFinSoir;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJourSemaine(): ?string
    {
        return $this->jourSemaine;
    }

    public function setJourSemaine(string $jourSemaine): self
    {
        $this->jourSemaine = $jourSemaine;

        return $this;
    }

    public function getHeureDebutMatin(): ?\DateTimeInterface
    {
        return $this->heureDebutMatin;
    }

    public function setHeureDebutMatin(?\DateTimeInterface $heureDebutMatin): self
    {
        $this->heureDebutMatin = $heureDebutMatin;

        return $this;
    }

    public function getHeureFinMatin(): ?\DateTimeInterface
    {
        return $this->heureFinMatin;
    }

    public function setHeureFinMatin(?\DateTimeInterface $heureFinMatin): self
    {
        $this->heureFinMatin = $heureFinMatin;

        return $this;
    }

    public function getHeureDebutSoir(): ?\DateTimeInterface
    {
        return $this->heureDebutSoir;
    }

    public function setHeureDebutSoir(?\DateTimeInterface $heureDebutSoir): self
    {
        $this->heureDebutSoir = $heureDebutSoir;

        return $this;
    }

    public function getHeureFinSoir(): ?\DateTimeInterface
    {
        return $this->heureFinSoir;
    }

    public function setHeureFinSoir(?\DateTimeInterface $heureFinSoir): self
    {
        $this->heureFinSoir = $heureFinSoir;

        return $this;
    }






}

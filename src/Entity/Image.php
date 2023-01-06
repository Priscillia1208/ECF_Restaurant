<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $sourceImage;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceImage(): ?string
    {
        return $this->sourceImage;
    }

    public function setSourceImage(string $sourceImage): self
    {
        $this->sourceImage = $sourceImage;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}

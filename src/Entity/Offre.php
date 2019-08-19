<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 */
class Offre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recruteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recruteur;

    /**
     * @ORM\Column(type="text")
     */
    private $description_poste;

    /**
     * @ORM\Column(type="integer")
     */
    private $salaire_poste;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ville_poste;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pays_poste;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publication;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRecruteur(): ?Recruteur
    {
        return $this->recruteur;
    }

    public function setRecruteur(?Recruteur $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
    }

    public function getDescriptionPoste(): ?string
    {
        return $this->description_poste;
    }

    public function setDescriptionPoste(string $description_poste): self
    {
        $this->description_poste = $description_poste;

        return $this;
    }

    public function getSalairePoste(): ?int
    {
        return $this->salaire_poste;
    }

    public function setSalairePoste(int $salaire_poste): self
    {
        $this->salaire_poste = $salaire_poste;

        return $this;
    }

    public function getVillePoste(): ?string
    {
        return $this->ville_poste;
    }

    public function setVillePoste(string $ville_poste): self
    {
        $this->ville_poste = $ville_poste;

        return $this;
    }

    public function getPaysPoste(): ?string
    {
        return $this->pays_poste;
    }

    public function setPaysPoste(string $pays_poste): self
    {
        $this->pays_poste = $pays_poste;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }
}

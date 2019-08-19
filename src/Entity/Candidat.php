<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 */
class Candidat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Membre", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre_fichier;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $atout;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $site_web;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salaire;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_disponibilite;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $type_contrat;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $metier;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee_experience;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $langue_parlee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(Membre $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getAutreFichier(): ?string
    {
        return $this->autre_fichier;
    }

    public function setAutreFichier(?string $autre_fichier): self
    {
        $this->autre_fichier = $autre_fichier;

        return $this;
    }

    public function getAtout(): ?string
    {
        return $this->atout;
    }

    public function setAtout(?string $atout): self
    {
        $this->atout = $atout;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->site_web;
    }

    public function setSiteWeb(?string $site_web): self
    {
        $this->site_web = $site_web;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(?int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getDateDisponibilite(): ?\DateTimeInterface
    {
        return $this->date_disponibilite;
    }

    public function setDateDisponibilite(?\DateTimeInterface $date_disponibilite): self
    {
        $this->date_disponibilite = $date_disponibilite;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->type_contrat;
    }

    public function setTypeContrat(?string $type_contrat): self
    {
        $this->type_contrat = $type_contrat;

        return $this;
    }

    public function getMetier(): ?string
    {
        return $this->metier;
    }

    public function setMetier(string $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    public function getAnneeExperience(): ?int
    {
        return $this->annee_experience;
    }

    public function setAnneeExperience(int $annee_experience): self
    {
        $this->annee_experience = $annee_experience;

        return $this;
    }

    public function getLangueParlee(): ?string
    {
        return $this->langue_parlee;
    }

    public function setLangueParlee(?string $langue_parlee): self
    {
        $this->langue_parlee = $langue_parlee;

        return $this;
    }
}

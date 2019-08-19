<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecruteurRepository")
 */
class Recruteur
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_employe;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $secteur_activite;

    /**
     * @ORM\Column(type="text")
     */
    private $logo_entreprise;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom_entreprise;

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

    public function getNbrEmploye(): ?int
    {
        return $this->nbr_employe;
    }

    public function setNbrEmploye(?int $nbr_employe): self
    {
        $this->nbr_employe = $nbr_employe;

        return $this;
    }

    public function getSecteurActivite(): ?string
    {
        return $this->secteur_activite;
    }

    public function setSecteurActivite(string $secteur_activite): self
    {
        $this->secteur_activite = $secteur_activite;

        return $this;
    }

    public function getLogoEntreprise(): ?string
    {
        return $this->logo_entreprise;
    }

    public function setLogoEntreprise(string $logo_entreprise): self
    {
        $this->logo_entreprise = $logo_entreprise;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }
}

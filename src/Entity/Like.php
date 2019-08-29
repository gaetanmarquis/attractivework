<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\Table("`like`")
 */
class Like
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Candidat")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recruteur")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $recruteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_like;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(max=10)
     */
    private $role_like;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

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

    public function getDateLike(): ?\DateTimeInterface
    {
        return $this->date_like;
    }

    public function setDateLike(\DateTimeInterface $date_like): self
    {
        $this->date_like = $date_like;

        return $this;
    }

    public function getRoleLike(): ?string
    {
        return $this->role_like;
    }

    public function setRoleLike(string $role_like): self
    {
        $this->role_like = $role_like;

        return $this;
    }
}

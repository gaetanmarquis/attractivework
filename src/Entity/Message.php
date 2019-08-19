<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
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
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\recruteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recruteur;

    /**
     * @ORM\Column(type="text")
     */
    private $messagze;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_message;

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

    public function getRecruteur(): ?recruteur
    {
        return $this->recruteur;
    }

    public function setRecruteur(?recruteur $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
    }

    public function getMessagze(): ?string
    {
        return $this->messagze;
    }

    public function setMessagze(string $messagze): self
    {
        $this->messagze = $messagze;

        return $this;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->date_message;
    }

    public function setDateMessage(\DateTimeInterface $date_message): self
    {
        $this->date_message = $date_message;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePayement;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $pricePayed;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typePayement;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statusPayement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePayement(): ?\DateTimeInterface
    {
        return $this->datePayement;
    }

    public function setDatePayement(?\DateTimeInterface $datePayement): self
    {
        $this->datePayement = $datePayement;

        return $this;
    }

    public function getPricePayed(): ?string
    {
        return $this->pricePayed;
    }

    public function setPricePayed(?string $pricePayed): self
    {
        $this->pricePayed = $pricePayed;

        return $this;
    }

    public function getTypePayement(): ?string
    {
        return $this->typePayement;
    }

    public function setTypePayement(string $typePayement): self
    {
        $this->typePayement = $typePayement;

        return $this;
    }

    public function getStatusPayement(): ?string
    {
        return $this->statusPayement;
    }

    public function setStatusPayement(string $statusPayement): self
    {
        $this->statusPayement = $statusPayement;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TextRepository")
 */
class Text
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $contentToTranslate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentTranslated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReception;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateReturn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="requestedTexts")
     */
    private $userRequester;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="translatedTexts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userTranslator;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContentToTranslate(): ?string
    {
        return $this->contentToTranslate;
    }

    public function setContentToTranslate(string $contentToTranslate): self
    {
        $this->contentToTranslate = $contentToTranslate;

        return $this;
    }

    public function getContentTranslated(): ?string
    {
        return $this->contentTranslated;
    }

    public function setContentTranslated(?string $contentTranslated): self
    {
        $this->contentTranslated = $contentTranslated;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->dateReturn;
    }

    public function setDateReturn(?\DateTimeInterface $dateReturn): self
    {
        $this->dateReturn = $dateReturn;

        return $this;
    }

    public function getUserRequester(): ?User
    {
        return $this->userRequester;
    }

    public function setUserRequester(?User $userRequester): self
    {
        $this->userRequester = $userRequester;

        return $this;
    }

    public function getUserTranslator(): ?User
    {
        return $this->userTranslator;
    }

    public function setUserTranslator(?User $userTranslator): self
    {
        $this->userTranslator = $userTranslator;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

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

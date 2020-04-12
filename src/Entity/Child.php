<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChildRepository")
 */
class Child
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateBirth;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="child")
     */
    private $participations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="children")
     */
    private $userParents;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->userParents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(\DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setChild($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->contains($participation)) {
            $this->participations->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getChild() === $this) {
                $participation->setChild(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserParents(): Collection
    {
        return $this->userParents;
    }

    public function addUserParent(User $userParent): self
    {
        if (!$this->userParents->contains($userParent)) {
            $this->userParents[] = $userParent;
        }

        return $this;
    }

    public function removeUserParent(User $userParent): self
    {
        if ($this->userParents->contains($userParent)) {
            $this->userParents->removeElement($userParent);
        }

        return $this;
    }
}

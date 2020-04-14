<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $place;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActivityExecution", mappedBy="activity", cascade={"persist", "remove"})
     */
    private $activityExecutions;

    public function __construct()
    {
        $this->activityExecutions = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|ActivityExecution[]
     */
    public function getActivityExecutions(): Collection
    {
       return $this->activityExecutions;
    }

    public function addActivityExecution(ActivityExecution $activityExecution): self
    {
        if (!$this->activityExecutions->contains($activityExecution)) {
            $this->activityExecutions[] = $activityExecution;
            $activityExecution->setActivity($this);
        }

        return $this;
    }

    public function removeActivityExecution(ActivityExecution $activityExecution): self
    {
        if ($this->activityExecutions->contains($activityExecution)) {
            $this->activityExecutions->removeElement($activityExecution);
            // set the owning side to null (unless already changed)
            if ($activityExecution->getActivity() === $this) {
                $activityExecution->setActivity(null);
            }
        }

        return $this;
    }
}

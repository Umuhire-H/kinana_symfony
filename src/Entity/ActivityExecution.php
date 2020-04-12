<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityExecutionRepository")
 */
class ActivityExecution
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $freePlace;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="activityExecutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="activityExecution")
     */
    private $participations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="activityExecutions")
     */
    private $userAnimators;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->userAnimators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFreePlace(): ?int
    {
        return $this->freePlace;
    }

    public function setFreePlace(int $freePlace): self
    {
        $this->freePlace = $freePlace;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

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
            $participation->setActivityExecution($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->contains($participation)) {
            $this->participations->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getActivityExecution() === $this) {
                $participation->setActivityExecution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserAnimators(): Collection
    {
        return $this->userAnimators;
    }

    public function addUserAnimator(User $userAnimator): self
    {
        if (!$this->userAnimators->contains($userAnimator)) {
            $this->userAnimators[] = $userAnimator;
        }

        return $this;
    }

    public function removeUserAnimator(User $userAnimator): self
    {
        if ($this->userAnimators->contains($userAnimator)) {
            $this->userAnimators->removeElement($userAnimator);
        }

        return $this;
    }
}

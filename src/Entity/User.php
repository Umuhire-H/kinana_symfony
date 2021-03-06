<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="user", cascade={"persist", "remove"})
     */
    private $participations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Child", mappedBy="userParents", cascade={"persist", "remove"})
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Text", mappedBy="userRequester", cascade={"persist", "remove"})
     */
    private $requestedTexts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Text", mappedBy="userTranslator", cascade={"persist", "remove"})
     */
    private $translatedTexts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ActivityExecution", inversedBy="userAnimators", cascade={"persist", "remove"})
     */
    private $activityExecutions; 


    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->requestedTexts = new ArrayCollection();
        $this->translatedTexts = new ArrayCollection();
        $this->activityExecutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $participation->setUser($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->contains($participation)) {
            $this->participations->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getUser() === $this) {
                $participation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Child[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->addUserParent($this);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            $child->removeUserParent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Text[]
     */
    public function getRequestedTexts(): Collection
    {
        return $this->requestedTexts;
    }

    public function addRequestedText(Text $requestedText): self
    {
        if (!$this->requestedTexts->contains($requestedText)) {
            $this->requestedTexts[] = $requestedText;
            $requestedText->setUserRequester($this);
        }

        return $this;
    }

    public function removeRequestedText(Text $requestedText): self
    {
        if ($this->requestedTexts->contains($requestedText)) {
            $this->requestedTexts->removeElement($requestedText);
            // set the owning side to null (unless already changed)
            if ($requestedText->getUserRequester() === $this) {
                $requestedText->setUserRequester(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Text[]
     */
    public function getTranslatedTexts(): Collection
    {
        return $this->translatedTexts;
    }

    public function addTranslatedText(Text $translatedText): self
    {
        if (!$this->translatedTexts->contains($translatedText)) {
            $this->translatedTexts[] = $translatedText;
            $translatedText->setUserTranslator($this);
        }

        return $this;
    }

    public function removeTranslatedText(Text $translatedText): self
    {
        if ($this->translatedTexts->contains($translatedText)) {
            $this->translatedTexts->removeElement($translatedText);
            // set the owning side to null (unless already changed)
            if ($translatedText->getUserTranslator() === $this) {
                $translatedText->setUserTranslator(null);
            }
        }

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
        }

        return $this;
    }

    public function removeActivityExecution(ActivityExecution $activityExecution): self
    {
        if ($this->activityExecutions->contains($activityExecution)) {
            $this->activityExecutions->removeElement($activityExecution);
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Idea
 *
 * @ORM\Table(name="idea")
 * @ORM\Entity
 */
class Idea
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @MaxDepth(1)
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="favoriteIdeas")
     */
    private $users;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @MaxDepth(1)
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="ideas")
     * @ORM\JoinTable(name="idea_has_category",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idea_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     */
    private $categories;

    /**
     * @MaxDepth(1)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ideas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExCompany", mappedBy="idea", orphanRemoval=true, cascade={"persist"})
     */
    private $exCompanies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExImages", mappedBy="idea", orphanRemoval=true, cascade={"persist"})
     */
    private $exImages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExUrl", mappedBy="idea", orphanRemoval=true, cascade={"persist"} )
     */
    private $exUrls;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->exCompanies = new ArrayCollection();
        $this->exImages = new ArrayCollection();
        $this->exUrls = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addIdea($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeIdea($this);
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ExCompany[]
     */
    public function getExCompanies(): Collection
    {
        return $this->exCompanies;
    }

    public function addExCompany(ExCompany $exCompany): self
    {
        if (!$this->exCompanies->contains($exCompany)) {
            $this->exCompanies[] = $exCompany;
            $exCompany->setIdea($this);
        }

        return $this;
    }

    public function removeExCompany(ExCompany $exCompany): self
    {
        if ($this->exCompanies->contains($exCompany)) {
            $this->exCompanies->removeElement($exCompany);
            // set the owning side to null (unless already changed)
            if ($exCompany->getIdea() === $this) {
                $exCompany->setIdea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExImages[]
     */
    public function getExImages(): Collection
    {
        return $this->exImages;
    }

    public function addExImage(ExImages $exImage): self
    {
        if (!$this->exImages->contains($exImage)) {
            $this->exImages[] = $exImage;
            $exImage->setIdea($this);
        }

        return $this;
    }

    public function removeExImage(ExImages $exImage): self
    {
        if ($this->exImages->contains($exImage)) {
            $this->exImages->removeElement($exImage);
            // set the owning side to null (unless already changed)
            if ($exImage->getIdea() === $this) {
                $exImage->setIdea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExUrl[]
     */
    public function getExUrls(): Collection
    {
        return $this->exUrls;
    }

    public function addExUrl(ExUrl $exUrl): self
    {
        if (!$this->exUrls->contains($exUrl)) {
            $this->exUrls[] = $exUrl;
            $exUrl->setIdea($this);
        }

        return $this;
    }

    public function removeExUrl(ExUrl $exUrl): self
    {
        if ($this->exUrls->contains($exUrl)) {
            $this->exUrls->removeElement($exUrl);
            // set the owning side to null (unless already changed)
            if ($exUrl->getIdea() === $this) {
                $exUrl->setIdea(null);
            }
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Category
 *
 * @ORM\Table(name="category", indexes={@ORM\Index(name="fk_category_category1_idx", columns={"category_id"})})
 * @ORM\Entity
 */
class Category
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
     * @var Category
     * @MaxDepth(1)
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @MaxDepth(1)
     *
     * @ORM\ManyToMany(targetEntity="Idea", mappedBy="categories")
     */
    private $ideas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ideas = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(?self $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Idea[]
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): self
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas[] = $idea;
            $idea->addCategory($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): self
    {
        if ($this->ideas->contains($idea)) {
            $this->ideas->removeElement($idea);
            $idea->removeCategory($this);
        }

        return $this;
    }

}

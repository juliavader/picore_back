<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExCompany
 *
 * @ORM\Table(name="ex_company", indexes={@ORM\Index(name="fk_ex_compagny_idea1_idx", columns={"idea_id"})})
 * @ORM\Entity
 */
class ExCompany
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
     * @var \Idea
     *
     * @ORM\ManyToOne(targetEntity="Idea")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idea_id", referencedColumnName="id")
     * })
     */
    private $idea;

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

    public function getIdea(): ?Idea
    {
        return $this->idea;
    }

    public function setIdea(?Idea $idea): self
    {
        $this->idea = $idea;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExUrl
 *
 * @ORM\Table(name="ex_url", indexes={@ORM\Index(name="fk_example_url_idea1_idx", columns={"idea_id"})})
 * @ORM\Entity
 */
class ExUrl
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Idea", inversedBy="exUrls", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
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

    public function setName(?string $name): self
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

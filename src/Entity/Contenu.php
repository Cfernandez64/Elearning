<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContenuRepository")
 */
class Contenu
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cour", inversedBy="relContents")
     */
    private $relCours;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->relCours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Cour[]
     */
    public function getRelCours(): Collection
    {
        return $this->relCours;
    }

    public function addRelCour(Cour $relCour): self
    {

        if (!$this->relCours->contains($relCour)) {
            $this->relCours[] = $relCour;
            $relCour->addRelContent($this);
        }

         return $this;
    }

    public function removeRelCour(Cour $relCour): self
    {
        if ($this->relCours->contains($relCour)) {
            $this->relCours->removeElement($relCour);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}

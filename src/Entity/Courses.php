<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursesRepository")
 */
class Courses
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teachers;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="cours", orphanRemoval=true)
     */
    private $sections;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contenu", mappedBy="cours")
     */
    private $contenus;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->contenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTeachers(): ?string
    {
        return $this->teachers;
    }

    public function setTeachers(string $teachers): self
    {
        $this->teachers = $teachers;

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

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setCours($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
            // set the owning side to null (unless already changed)
            if ($section->getCours() === $this) {
                $section->setCours(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contenu[]
     */
    public function getContenus(): Collection
    {
        return $this->contenus;
    }

    public function addContenus(Contenu $contenus): self
    {
        if (!$this->contenus->contains($contenus)) {
            $this->contenus[] = $contenus;
            $contenus->addCour($this);
        }

        return $this;
    }

    public function removeContenus(Contenu $contenus): self
    {
        if ($this->contenus->contains($contenus)) {
            $this->contenus->removeElement($contenus);
            $contenus->removeCour($this);
        }

        return $this;
    }

}

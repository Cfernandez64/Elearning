<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Contenu", mappedBy="relCours")
     */
    private $relContents;

    public function __construct()
    {
         $this->contenus = new ArrayCollection();
         $this->contents = new ArrayCollection();
         $this->relContenus = new ArrayCollection();
         $this->relContents = new ArrayCollection();
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
     * @return Collection|Contenu[]
     */
    public function getRelContents(): Collection
    {
        return $this->relContents;
    }

    public function addRelContent(Contenu $relContent): self
    {
        if (!$this->relContents->contains($relContent)) {
            $this->relContents[] = $relContent;
            $relContent->addRelCour($this);
        }

        return $this;
    }

    public function removeRelContent(Contenu $relContent): self
    {
        if ($this->relContents->contains($relContent)) {
            $this->relContents->removeElement($relContent);
            $relContent->removeRelCour($this);
        }

        return $this;
    }

}

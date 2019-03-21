<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonRepository")
 */
class Lesson
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $teacher;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LessonContent", mappedBy="lessons")
     */
    private $lessonContents;

    public function __construct()
    {
        $this->lessonContents = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getTeacher(): ?string
    {
        return $this->teacher;
    }

    public function setTeacher(?string $teacher): self
    {
        $this->teacher = $teacher;

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

    /**
     * @return Collection|LessonContent[]
     */
    public function getLessonContents(): Collection
    {
        return $this->lessonContents;
    }

    public function addLessonContent(LessonContent $lessonContent): self
    {
        if (!$this->lessonContents->contains($lessonContent)) {
            $this->lessonContents[] = $lessonContent;
            $lessonContent->setLessons($this);
        }

        return $this;
    }

    public function removeLessonContent(LessonContent $lessonContent): self
    {
        if ($this->lessonContents->contains($lessonContent)) {
            $this->lessonContents->removeElement($lessonContent);
            // set the owning side to null (unless already changed)
            if ($lessonContent->getLessons() === $this) {
                $lessonContent->setLessons(null);
            }
        }

        return $this;
    }
}

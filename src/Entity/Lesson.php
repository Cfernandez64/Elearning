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
     * @ORM\Column(type="string", length=255)
     */
    private $teacher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LessonsContents", mappedBy="lesson")
     */
    private $lessonsContents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Content", mappedBy="inLessons")
     */
    private $contents;


    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->lessonsContents = new ArrayCollection();
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

    public function getTeacher(): ?string
    {
        return $this->teacher;
    }

    public function setTeacher(string $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

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
     * @return Collection|LessonsContents[]
     */
    public function getLessonsContents(): Collection
    {
        return $this->lessonsContents;
    }

    public function addLessonsContent(LessonsContents $lessonsContent): self
    {
        if (!$this->lessonsContents->contains($lessonsContent)) {
            $this->lessonsContents[] = $lessonsContent;
            $lessonsContent->setLesson($this);
        }

        return $this;
    }

    public function removeLessonsContent(LessonsContents $lessonsContent): self
    {
        if ($this->lessonsContents->contains($lessonsContent)) {
            $this->lessonsContents->removeElement($lessonsContent);
            // set the owning side to null (unless already changed)
            if ($lessonsContent->getLesson() === $this) {
                $lessonsContent->setLesson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Content[]
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->addInLesson($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->contains($content)) {
            $this->contents->removeElement($content);
            $content->removeInLesson($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->title;
    }


}

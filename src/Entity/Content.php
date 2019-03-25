<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContentRepository")
 */
class Content
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LessonContent", mappedBy="contents")
     */
    private $lessonContents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Lesson", inversedBy="contents")
     */
    private $lessons;


    public function __construct()
    {
        $this->lessonContents = new ArrayCollection();
        $this->lessons = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
            $lessonContent->setContents($this);
        }

        return $this;
    }

    public function removeLessonContent(LessonContent $lessonContent): self
    {
        if ($this->lessonContents->contains($lessonContent)) {
            $this->lessonContents->removeElement($lessonContent);
            // set the owning side to null (unless already changed)
            if ($lessonContent->getContents() === $this) {
                $lessonContent->setContents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->contains($lesson)) {
            $this->lessons->removeElement($lesson);
        }

        return $this;
    }
}

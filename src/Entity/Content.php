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
     * @ORM\OneToMany(targetEntity="App\Entity\LessonsContents", mappedBy="content")
     */
    private $lessonsContents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Lesson", inversedBy="contents")
     */
    private $inLessons;



    public function __construct()
    {
        $this->inLessons = new ArrayCollection();
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
            $lessonsContent->setContent($this);
        }

        return $this;
    }

    public function removeLessonsContent(LessonsContents $lessonsContent): self
    {
        if ($this->lessonsContents->contains($lessonsContent)) {
            $this->lessonsContents->removeElement($lessonsContent);
            // set the owning side to null (unless already changed)
            if ($lessonsContent->getContent() === $this) {
                $lessonsContent->setContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function getInLessons(): Collection
    {
        return $this->inLessons;
    }

    public function addInLesson(Lesson $inLesson): self
    {
        if (!$this->inLessons->contains($inLesson)) {
            $this->inLessons[] = $inLesson;
        }

        return $this;
    }

    public function removeInLesson(Lesson $inLesson): self
    {
        if ($this->inLessons->contains($inLesson)) {
            $this->inLessons->removeElement($inLesson);
        }

        return $this;
    }

    public function __toString() {
        return $this->title;
    }


}

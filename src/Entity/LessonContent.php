<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonContentRepository")
 */
class LessonContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rank;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="lessonContents")
     */
    private $lessons;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Content", inversedBy="lessonContents")
     */
    private $contents;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getLessons(): ?Lesson
    {
        return $this->lessons;
    }

    public function setLessons(?Lesson $lessons): self
    {
        $this->lessons = $lessons;

        return $this;
    }

    public function getContents(): ?Content
    {
        return $this->contents;
    }

    public function setContents(?Content $contents): self
    {
        $this->contents = $contents;

        return $this;
    }
}

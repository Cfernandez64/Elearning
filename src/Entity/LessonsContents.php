<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonsContentsRepository")
 */
class LessonsContents
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="lessonsContents")
     */
    private $lesson;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Content", inversedBy="lessonsContents")
     */
    private $content;

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

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function __toString() {
        return 'NULL';
    }
}

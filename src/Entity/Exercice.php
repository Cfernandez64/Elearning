<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExerciceRepository")
 */
class Exercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Content", inversedBy="exercices")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propositionUn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propositionDeux;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propositionTrois;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?Content
    {
        return $this->contenu;
    }

    public function setContenu(?Content $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getPropositionUn(): ?string
    {
        return $this->propositionUn;
    }

    public function setPropositionUn(string $propositionUn): self
    {
        $this->propositionUn = $propositionUn;

        return $this;
    }

    public function getPropositionDeux(): ?string
    {
        return $this->propositionDeux;
    }

    public function setPropositionDeux(string $propositionDeux): self
    {
        $this->propositionDeux = $propositionDeux;

        return $this;
    }

    public function getPropositionTrois(): ?string
    {
        return $this->propositionTrois;
    }

    public function setPropositionTrois(string $propositionTrois): self
    {
        $this->propositionTrois = $propositionTrois;

        return $this;
    }
}

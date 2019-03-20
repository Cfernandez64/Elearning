<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvanceRepository")
 */
class Advance
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
    private $percentage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stagiaire", inversedBy="advance", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $stagiaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenu", mappedBy="advance")
     */
    private $contenu;

    public function __construct()
    {
        $this->contenu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(Stagiaire $stagiaire): self
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    /**
     * @return Collection|Contenu[]
     */
    public function getContenu(): Collection
    {
        return $this->contenu;
    }

    public function addContenu(Contenu $contenu): self
    {
        if (!$this->contenu->contains($contenu)) {
            $this->contenu[] = $contenu;
            $contenu->setAdvance($this);
        }

        return $this;
    }

    public function removeContenu(Contenu $contenu): self
    {
        if ($this->contenu->contains($contenu)) {
            $this->contenu->removeElement($contenu);
            // set the owning side to null (unless already changed)
            if ($contenu->getAdvance() === $this) {
                $contenu->setAdvance(null);
            }
        }

        return $this;
    }
}

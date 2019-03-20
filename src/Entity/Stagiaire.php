<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StagiaireRepository")
 */
class Stagiaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Advance", mappedBy="stagiaire", cascade={"persist", "remove"})
     */
    private $advance;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Inscription", mappedBy="stagiaire", cascade={"persist", "remove"})
     */
    private $inscription;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdvance(): ?Advance
    {
        return $this->advance;
    }

    public function setAdvance(Advance $advance): self
    {
        $this->advance = $advance;

        // set the owning side of the relation if necessary
        if ($this !== $advance->getStagiaire()) {
            $advance->setStagiaire($this);
        }

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(Inscription $inscription): self
    {
        $this->inscription = $inscription;

        // set the owning side of the relation if necessary
        if ($this !== $inscription->getStagiaire()) {
            $inscription->setStagiaire($this);
        }

        return $this;
    }
}

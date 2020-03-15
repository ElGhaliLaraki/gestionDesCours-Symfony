<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NiveauRepository")
 */
class Niveau
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
    private $Nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cours", mappedBy="niveau")
     */
    private $Cours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="NiveauEtu")
     */
    private $Etudiant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Enseignant", inversedBy="NiveauEns")
     */
    private $Enseignant;

    public function __construct()
    {
        $this->Cours = new ArrayCollection();
        $this->Etudiant = new ArrayCollection();
        $this->Enseignant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->Cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->Cours->contains($cour)) {
            $this->Cours[] = $cour;
            $cour->setNiveau($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->Cours->contains($cour)) {
            $this->Cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getNiveau() === $this) {
                $cour->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiant(): Collection
    {
        return $this->Etudiant;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->Etudiant->contains($etudiant)) {
            $this->Etudiant[] = $etudiant;
            $etudiant->setNiveauEtu($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->Etudiant->contains($etudiant)) {
            $this->Etudiant->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getNiveauEtu() === $this) {
                $etudiant->setNiveauEtu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Enseignant[]
     */
    public function getEnseignant(): Collection
    {
        return $this->Enseignant;
    }

    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->Enseignant->contains($enseignant)) {
            $this->Enseignant[] = $enseignant;
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): self
    {
        if ($this->Enseignant->contains($enseignant)) {
            $this->Enseignant->removeElement($enseignant);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnseignantRepository")
 */
class Enseignant
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
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Matricule;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Niveau", mappedBy="Enseignant")
     */
    private $NiveauEns;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cours", mappedBy="Enseignantcrs")
     */
    private $Cours;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->NiveauEns = new ArrayCollection();
        $this->Cours = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->Departement;
    }

    public function setDepartement(string $Departement): self
    {
        $this->Departement = $Departement;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->Tel;
    }

    public function setTel(int $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveauEns(): Collection
    {
        return $this->NiveauEns;
    }

    public function addNiveauEn(Niveau $niveauEn): self
    {
        if (!$this->NiveauEns->contains($niveauEn)) {
            $this->NiveauEns[] = $niveauEn;
            $niveauEn->addEnseignant($this);
        }

        return $this;
    }

    public function removeNiveauEn(Niveau $niveauEn): self
    {
        if ($this->NiveauEns->contains($niveauEn)) {
            $this->NiveauEns->removeElement($niveauEn);
            $niveauEn->removeEnseignant($this);
        }

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
            $cour->setEnseignantcrs($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->Cours->contains($cour)) {
            $this->Cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getEnseignantcrs() === $this) {
                $cour->setEnseignantcrs(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}

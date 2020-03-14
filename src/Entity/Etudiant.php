<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant
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
    private $Email;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Niveau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CNE;

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
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

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

    public function getNiveau(): ?string
    {
        return $this->Niveau;
    }

    public function setNiveau(string $Niveau): self
    {
        $this->Niveau = $Niveau;

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

    public function getCNE(): ?string
    {
        return $this->CNE;
    }

    public function setCNE(string $CNE): self
    {
        $this->CNE = $CNE;

        return $this;
    }
}

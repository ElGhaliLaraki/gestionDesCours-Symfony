<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already used")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;
    public function __construct()
    {
        $this->isActive = true;
		$this->roles = ['ROLE_USER'];
    }

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * Assert\Length(min="8",minMessage="Votre mot de passe doit etre au minimum 8 caractére")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
   * @Assert\NotBlank()
   * @Assert\Length(max=4096)
   * Assert\Length(min="8",minMessage="Votre mot de passe doit etre au minimum 8 caractére")
   * @Assert\EqualTo(propertyPath="password", message=" Vous n'avez pas tapé le meme Mot de passe")
   */
  private $confirm_password;

  /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return (array)$this->roles;
         
    }

    public function setRoles(array $roles): self
    {
        if (!in_array('ROLE_USER', $roles))
		{
			$roles[] = 'ROLE_USER';
		}
		foreach ($roles as $role)
		{
			if(substr($role, 0, 5) !== 'ROLE_') {
				throw new InvalidArgumentException("Chaque rôle doit commencer par 'ROLE_'");
			}
		}
		$this->roles = $roles;
		return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getConfirmPassword(): string
    {
        return (string) $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

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

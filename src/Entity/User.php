<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email]
    private ?string $email = null;
    #[ORM\Column(length: 30, nullable: true)]
    private ?string $phone = null;
    #[ORM\Column(options: ['default' => 1])]
    private ?int $gender = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $bornAt = null;
    #[ORM\Column(length: 255)]
    private ?string $password = null;
    #[ORM\Column(length: 100, options: ['default' => 'trader'])]
    private ?string $role = null;
    #[ORM\Column(length: 5, nullable: true)]
    private ?string $language = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBornAt(): ?\DateTimeImmutable
    {
        return $this->bornAt;
    }

    public function setBornAt(\DateTimeImmutable $bornAt): self
    {
        $this->bornAt = $bornAt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }
}

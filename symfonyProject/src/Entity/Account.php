<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $username;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $street;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $city;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $konto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?int
    {
        return $this->city;
    }

    public function setCity(?int $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getKonto(): ?int
    {
        return $this->konto;
    }

    public function setKonto(?int $konto): self
    {
        $this->konto = $konto;

        return $this;
    }
}

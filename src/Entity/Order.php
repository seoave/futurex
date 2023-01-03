<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $acceptorId = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?int $date = null;

    #[ORM\Column]
    private ?int $offerId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcceptorId(): ?int
    {
        return $this->acceptorId;
    }

    public function setAcceptorId(int $acceptorId): self
    {
        $this->acceptorId = $acceptorId;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOfferId(): ?int
    {
        return $this->offerId;
    }

    public function setOfferId(int $offerId): self
    {
        $this->offerId = $offerId;

        return $this;
    }
}

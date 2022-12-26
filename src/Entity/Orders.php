<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $offerMakerId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfferMakerId(): ?int
    {
        return $this->offerMakerId;
    }

    public function setOfferMakerId(int $offerMakerId): self
    {
        $this->offerMakerId = $offerMakerId;

        return $this;
    }
}

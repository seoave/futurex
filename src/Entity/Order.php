<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?float $amount = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offer $initialOffer = null;
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offer $matchOffer = null;
    #[ORM\Column(length: 7, options: ['default' => 'draft'])]
    private ?string $status = 'draft';
    #[ORM\Column]
    private ?float $total = null;

    /**
     * @param \DateTimeImmutable|null $createdAt
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Offer|null
     */
    public function getInitialOffer(): ?Offer
    {
        return $this->initialOffer;
    }

    /**
     * @param Offer|null $initialOffer
     */
    public function setInitialOffer(?Offer $initialOffer): void
    {
        $this->initialOffer = $initialOffer;
    }

    /**
     * @return Offer|null
     */
    public function getMatchOffer(): ?Offer
    {
        return $this->matchOffer;
    }

    /**
     * @param Offer|null $matchOffer
     */
    public function setMatchOffer(?Offer $matchOffer): void
    {
        $this->matchOffer = $matchOffer;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PurchaseHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseHistoryRepository::class)]
class PurchaseHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Purchase $purchase = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    public function __construct()
    {
        $createdAtDate = new \DateTime("now");
        $this->setDatePurchase($createdAtDate->format('Y-m-d H:i:s'));
        $this->purchaseHistories = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $total = null;

    #[ORM\Column(length: 255)]
    private ?string $datePurchase = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $tokenPurchase = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: PurchaseHistory::class)]
    private Collection $purchaseHistories;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trackLink = null;

    #[ORM\Column(length: 255)]
    private ?string $PaiementStatus = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column]
    private ?bool $consulted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDatePurchase(): ?string
    {
        return $this->datePurchase;
    }

    public function setDatePurchase(string $datePurchase): self
    {
        $this->datePurchase = $datePurchase;

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

    public function getTokenPurchase(): ?string
    {
        return $this->tokenPurchase;
    }

    public function setTokenPurchase(string $tokenPurchase): self
    {
        $this->tokenPurchase = $tokenPurchase;

        return $this;
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

    /**
     * @return Collection<int, PurchaseHistory>
     */
    public function getPurchaseHistories(): Collection
    {
        return $this->purchaseHistories;
    }

    public function addPurchaseHistory(PurchaseHistory $purchaseHistory): self
    {
        if (!$this->purchaseHistories->contains($purchaseHistory)) {
            $this->purchaseHistories->add($purchaseHistory);
            $purchaseHistory->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseHistory(PurchaseHistory $purchaseHistory): self
    {
        if ($this->purchaseHistories->removeElement($purchaseHistory)) {
            // set the owning side to null (unless already changed)
            if ($purchaseHistory->getPurchase() === $this) {
                $purchaseHistory->setPurchase(null);
            }
        }

        return $this;
    }

    public function getTrackLink(): ?string
    {
        return $this->trackLink;
    }

    public function setTrackLink(?string $trackLink): self
    {
        $this->trackLink = $trackLink;

        return $this;
    }

    public function getPaiementStatus(): ?string
    {
        return $this->PaiementStatus;
    }

    public function setPaiementStatus(string $PaiementStatus): self
    {
        $this->PaiementStatus = $PaiementStatus;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function isConsulted(): ?bool
    {
        return $this->consulted;
    }

    public function setConsulted(bool $consulted): self
    {
        $this->consulted = $consulted;

        return $this;
    }
}

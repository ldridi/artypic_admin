<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    public function __construct()
    {
        $createdAtDate = new \DateTime("now");
        $this->setDateReview($createdAtDate->format('Y-m-d'));
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dateReview = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\Column(length: 255)]
    private ?string $stars = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?bool $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReview(): ?string
    {
        return $this->dateReview;
    }

    public function setDateReview(string $dateReview): self
    {
        $this->dateReview = $dateReview;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getStars(): ?string
    {
        return $this->stars;
    }

    public function setStars(string $stars): self
    {
        $this->stars = $stars;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}

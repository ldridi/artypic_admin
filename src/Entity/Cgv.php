<?php

namespace App\Entity;

use App\Repository\CgvRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CgvRepository::class)]
class Cgv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    public function getId(): ?int
    {
        return $this->id;
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
}

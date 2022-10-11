<?php

namespace App\Entity;

use App\Repository\CguRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CguRepository::class)]
class Cgu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }
}

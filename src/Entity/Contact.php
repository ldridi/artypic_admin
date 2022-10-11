<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $dayFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $dayTo = null;

    #[ORM\Column(length: 255)]
    private ?string $hourFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $hourTo = null;

    #[ORM\Column(length: 255)]
    private ?string $dayClosed = null;

    #[ORM\Column(length: 255)]
    private ?string $hourClosed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getDayFrom(): ?string
    {
        return $this->dayFrom;
    }

    public function setDayFrom(string $dayFrom): self
    {
        $this->dayFrom = $dayFrom;

        return $this;
    }

    public function getDayTo(): ?string
    {
        return $this->dayTo;
    }

    public function setDayTo(string $dayTo): self
    {
        $this->dayTo = $dayTo;

        return $this;
    }

    public function getHourFrom(): ?string
    {
        return $this->hourFrom;
    }

    public function setHourFrom(string $hourFrom): self
    {
        $this->hourFrom = $hourFrom;

        return $this;
    }

    public function getHourTo(): ?string
    {
        return $this->hourTo;
    }

    public function setHourTo(string $hourTo): self
    {
        $this->hourTo = $hourTo;

        return $this;
    }

    public function getDayClosed(): ?string
    {
        return $this->dayClosed;
    }

    public function setDayClosed(string $dayClosed): self
    {
        $this->dayClosed = $dayClosed;

        return $this;
    }

    public function getHourClosed(): ?string
    {
        return $this->hourClosed;
    }

    public function setHourClosed(string $hourClosed): self
    {
        $this->hourClosed = $hourClosed;

        return $this;
    }
}

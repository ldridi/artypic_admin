<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texte = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubjectMessage $subject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $responseToContact = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $dateContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateReponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getSubject(): ?SubjectMessage
    {
        return $this->subject;
    }

    public function setSubject(?SubjectMessage $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getResponseToContact(): ?string
    {
        return $this->responseToContact;
    }

    public function setResponseToContact(?string $responseToContact): self
    {
        $this->responseToContact = $responseToContact;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateContact(): ?string
    {
        return $this->dateContact;
    }

    public function setDateContact(string $dateContact): self
    {
        $this->dateContact = $dateContact;

        return $this;
    }

    public function getDateReponse(): ?string
    {
        return $this->dateReponse;
    }

    public function setDateReponse(?string $dateReponse): self
    {
        $this->dateReponse = $dateReponse;

        return $this;
    }
}

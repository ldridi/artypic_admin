<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyAdresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyCity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyZipcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyCountry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyTel = null;

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

    /**
     * @Assert\NotBlank(message="Please, upload the photo.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" , "image/webp"})
     */
    #[ORM\Column(length: 255, nullable: true)]
    private $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyAdresse(): ?string
    {
        return $this->companyAdresse;
    }

    public function setCompanyAdresse(?string $companyAdresse): self
    {
        $this->companyAdresse = $companyAdresse;

        return $this;
    }

    public function getCompanyCity(): ?string
    {
        return $this->companyCity;
    }

    public function setCompanyCity(?string $companyCity): self
    {
        $this->companyCity = $companyCity;

        return $this;
    }

    public function getCompanyZipcode(): ?string
    {
        return $this->companyZipcode;
    }

    public function setCompanyZipcode(?string $companyZipcode): self
    {
        $this->companyZipcode = $companyZipcode;

        return $this;
    }

    public function getCompanyCountry(): ?string
    {
        return $this->companyCountry;
    }

    public function setCompanyCountry(?string $companyCountry): self
    {
        $this->companyCountry = $companyCountry;

        return $this;
    }

    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(?string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }

    public function getCompanyPhone(): ?string
    {
        return $this->companyPhone;
    }

    public function setCompanyPhone(?string $companyPhone): self
    {
        $this->companyPhone = $companyPhone;

        return $this;
    }

    public function getCompanyTel(): ?string
    {
        return $this->companyTel;
    }

    public function setCompanyTel(?string $companyTel): self
    {
        $this->companyTel = $companyTel;

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

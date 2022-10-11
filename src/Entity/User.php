<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Purchase::class)]
    private Collection $purchases;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nickname = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Wishlist::class)]
    private Collection $wishlists;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PurchaseHistory::class)]
    private Collection $purchaseHistories;

    #[ORM\ManyToMany(targetEntity: PromoCode::class, inversedBy: 'users')]
    private Collection $coupon;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adressePurchase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cityPurchase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipcodePurchase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $countryPurchase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phonePurchase = null;

    #[ORM\Column(length: 255)]
    private ?string $dateCreation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeToken = null;

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


    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->wishlists = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->purchaseHistories = new ArrayCollection();
        $this->coupon = new ArrayCollection();
        $createdAtDate = new \DateTime("now");
        $this->setDateCreation($createdAtDate->format('Y-m-d H:i:s'));
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

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString(){
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setUser($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getUser() === $this) {
                $purchase->setUser(null);
            }
        }

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return Collection<int, Wishlist>
     */
    public function getWishlists(): Collection
    {
        return $this->wishlists;
    }

    public function addWishlist(Wishlist $wishlist): self
    {
        if (!$this->wishlists->contains($wishlist)) {
            $this->wishlists->add($wishlist);
            $wishlist->setUser($this);
        }

        return $this;
    }

    public function removeWishlist(Wishlist $wishlist): self
    {
        if ($this->wishlists->removeElement($wishlist)) {
            // set the owning side to null (unless already changed)
            if ($wishlist->getUser() === $this) {
                $wishlist->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

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
            $purchaseHistory->setUser($this);
        }

        return $this;
    }

    public function removePurchaseHistory(PurchaseHistory $purchaseHistory): self
    {
        if ($this->purchaseHistories->removeElement($purchaseHistory)) {
            // set the owning side to null (unless already changed)
            if ($purchaseHistory->getUser() === $this) {
                $purchaseHistory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PromoCode>
     */
    public function getCoupon(): Collection
    {
        return $this->coupon;
    }

    public function addCoupon(PromoCode $coupon): self
    {
        if (!$this->coupon->contains($coupon)) {
            $this->coupon->add($coupon);
        }

        return $this;
    }

    public function removeCoupon(PromoCode $coupon): self
    {
        $this->coupon->removeElement($coupon);

        return $this;
    }

    public function getAdressePurchase(): ?string
    {
        return $this->adressePurchase;
    }

    public function setAdressePurchase(?string $adressePurchase): self
    {
        $this->adressePurchase = $adressePurchase;

        return $this;
    }

    public function getCityPurchase(): ?string
    {
        return $this->cityPurchase;
    }

    public function setCityPurchase(?string $cityPurchase): self
    {
        $this->cityPurchase = $cityPurchase;

        return $this;
    }

    public function getZipcodePurchase(): ?string
    {
        return $this->zipcodePurchase;
    }

    public function setZipcodePurchase(?string $zipcodePurchase): self
    {
        $this->zipcodePurchase = $zipcodePurchase;

        return $this;
    }

    public function getCountryPurchase(): ?string
    {
        return $this->countryPurchase;
    }

    public function setCountryPurchase(?string $countryPurchase): self
    {
        $this->countryPurchase = $countryPurchase;

        return $this;
    }

    public function getPhonePurchase(): ?string
    {
        return $this->phonePurchase;
    }

    public function setPhonePurchase(?string $phonePurchase): self
    {
        $this->phonePurchase = $phonePurchase;

        return $this;
    }

    public function getDateCreation(): ?string
    {
        return $this->dateCreation;
    }

    public function setDateCreation(string $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCodeToken(): ?string
    {
        return $this->codeToken;
    }

    public function setCodeToken(?string $codeToken): self
    {
        $this->codeToken = $codeToken;

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

<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateBecameCustomer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=CustomerType::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customerType;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity=CustomerPurchase::class, mappedBy="customer", orphanRemoval=true)
     */
    private $customerPurchases;

    public function __construct()
    {
        $this->customerPurchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getDateBecameCustomer(): ?\DateTimeInterface
    {
        return $this->dateBecameCustomer;
    }

    public function setDateBecameCustomer(?\DateTimeInterface $dateBecameCustomer): self
    {
        $this->dateBecameCustomer = $dateBecameCustomer;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getCustomerType(): ?customerType
    {
        return $this->customerType;
    }

    public function setCustomerType(?customerType $customerType): self
    {
        $this->customerType = $customerType;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|CustomerPurchase[]
     */
    public function getCustomerPurchases(): Collection
    {
        return $this->customerPurchases;
    }

    public function addCustomerPurchase(CustomerPurchase $customerPurchase): self
    {
        if (!$this->customerPurchases->contains($customerPurchase)) {
            $this->customerPurchases[] = $customerPurchase;
            $customerPurchase->setCustomer($this);
        }

        return $this;
    }

    public function removeCustomerPurchase(CustomerPurchase $customerPurchase): self
    {
        if ($this->customerPurchases->removeElement($customerPurchase)) {
            // set the owning side to null (unless already changed)
            if ($customerPurchase->getCustomer() === $this) {
                $customerPurchase->setCustomer(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
        // TODO: Implement __toString() method.
    }
}

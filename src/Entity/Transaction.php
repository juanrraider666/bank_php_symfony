<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=CustomerPurchase::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchase;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Account;

    /**
     * @ORM\ManyToOne(targetEntity=TransactionType::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TransactionType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPurchase(): ?CustomerPurchase
    {
        return $this->purchase;
    }

    public function setPurchase(?CustomerPurchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->Account;
    }

    public function setAccount(?Account $Account): self
    {
        $this->Account = $Account;

        return $this;
    }

    public function getTransactionType(): ?TransactionType
    {
        return $this->TransactionType;
    }

    public function setTransactionType(?TransactionType $TransactionType): self
    {
        $this->TransactionType = $TransactionType;

        return $this;
    }
}

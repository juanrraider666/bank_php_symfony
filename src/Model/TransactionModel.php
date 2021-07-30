<?php


namespace App\Model;


class TransactionModel
{

    protected $originAccount;

    protected $destinationAccount;

    protected $amount;

    protected $transactionType;

    public function __construct($originAccount, $destinationAccount = null, $transactionType = null, $amount = 0)
    {
        $this->originAccount = $originAccount;
        $this->destinationAccount = $destinationAccount;
        $this->transactionType = $transactionType;
        $this->amount = $amount;
    }

    public static function transaction($originAccount, $destinationAccount = null, $transactionType = null, $amount = 0)
    {
        return new static($originAccount,$destinationAccount, $transactionType, $amount);
    }

    /**
     * @return mixed
     */
    public function getOriginAccount()
    {
        return $this->originAccount;
    }

    /**
     * @param mixed $originAccount
     */
    public function setOriginAccount($originAccount): void
    {
        $this->originAccount = $originAccount;
    }

    /**
     * @return mixed
     */
    public function getDestinationAccount()
    {
        return $this->destinationAccount;
    }

    /**
     * @param mixed $destinationAccount
     */
    public function setDestinationAccount($destinationAccount): void
    {
        $this->destinationAccount = $destinationAccount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param mixed $transactionType
     */
    public function setTransactionType($transactionType): void
    {
        $this->transactionType = $transactionType;
    }

}
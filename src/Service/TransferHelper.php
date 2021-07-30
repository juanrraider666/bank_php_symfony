<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Customer;
use App\Entity\CustomerPurchase;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TransferHelper
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transfer(Transaction $transaction, Account $account): Transaction
    {
       $amount = $transaction->getAmount();
       $destinationAccount = $transaction->getAccount();

       $tr = new Transaction();
       $tr->setAccount($destinationAccount);
       $tr->setTransactionType($transaction->getTransactionType());
       $tr->setAmount($amount);

       $purchase = CustomerPurchase::purchase($account->getCustomer()->last(), 1);

       $amountAccount = $account->getAmount() - $amount;
       $account->setAmount($amountAccount);
       $destinationAccount->setAmount($amount);

       $tr->setPurchase($purchase);

       $this->entityManager->persist($tr);
       $this->entityManager->flush();

       return $tr;
   }


}

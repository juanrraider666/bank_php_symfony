<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Customer;
use App\Entity\CustomerPurchase;
use App\Entity\Transaction;
use App\Entity\User;
use App\Model\TransactionModel;
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

    public function transfer(TransactionModel $transaction): Transaction
    {
       $amount = $transaction->getAmount();
       $destinationAccount = $transaction->getDestinationAccount();
       $originAccount = $transaction->getOriginAccount();

       $tr = new Transaction();

       $destinationAccount->setAmount($destinationAccount->getAmount() + $amount);
       $tr->setAccount($destinationAccount);
       $tr->setTransactionType($transaction->getTransactionType());
       $tr->setAmount($amount);
       $tr->setControlNumber($tr->generateControlNumber($destinationAccount->getCustomer()->last()));

       $amountAccount = $originAccount->getAmount() - $amount;
        $originAccount->setAmount($amountAccount);
       $purchase = CustomerPurchase::purchase($originAccount->getCustomer()->last(), 1);

       $tr->setPurchase($purchase);

       $this->entityManager->persist($tr);
       $this->entityManager->flush();
       return $tr;
   }


}

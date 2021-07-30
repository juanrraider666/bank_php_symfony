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
       $tr->setAccount($destinationAccount);
       $tr->setTransactionType($transaction->getTransactionType());
       $tr->setAmount($amount);
       $tr->setControlNumber($tr->generateControlNumber($destinationAccount->getCustomer()->last()));

       $purchase = CustomerPurchase::purchase($originAccount->getCustomer()->last(), 1);

       $amountAccount = $originAccount->getAmount() - $amount;
       $originAccount->setAmount($amountAccount);

       $destinationAccount->setAmount($destinationAccount->getAmount() + $amount);

       $tr->setPurchase($purchase);

       $this->entityManager->persist($tr);
       $this->entityManager->flush();

       return $tr;
   }


}

<?php


namespace App\Validator;


use App\Model\TransactionModel;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use UnexpectedValueException;

class AmountLessThanValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {

        /** @var TransactionModel $transaction */
        $transaction = $value;
        $myAccount = $transaction->getOriginAccount();
        $myAmount = $transaction->getAmount();

        if (null === $myAmount || '' === $myAmount) {
            return;
        }


        if (is_string($myAmount)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($myAmount, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        if ($myAmount <= 0) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $myAmount)
                ->addViolation();
        }

        if($myAmount > $myAccount->getAmount()){
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->messageNotFound)
                ->setParameter('{{ string }}', $myAccount->getName())
                ->addViolation();
        }


    }
}

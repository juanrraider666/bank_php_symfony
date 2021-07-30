<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AmountLessThan extends Constraint
{
    public $message = 'El monto a transferir debe ser superior a 0: monto dado "{{ string }}"';
    public $messageNotFound = 'La cuenta "{{ string }}" no cuenta con fondos suficientes.';

    public function validatedBy()
    {
        return static::class.'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}

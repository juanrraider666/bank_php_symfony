<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AmountLessThan extends Constraint
{
    public $message = 'La cuenta "{{ string }}" no cuenta con fondos suficientes.';

    public function validatedBy()
    {
        return static::class.'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}

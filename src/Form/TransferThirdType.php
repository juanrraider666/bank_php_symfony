<?php


namespace App\Form;


use App\Entity\TransactionType;
use App\Model\TransactionModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferThirdType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transactionType', EntityType::class,[
                'label_attr' => ['class' => 'form-control-label'],
                'attr' => [
                    'data-widget' => 'select2',
                    'data-characteristic' => 'transactionType',
                ],
                'class' => TransactionType::class,
                'choice_attr' => static function (TransactionType $transactionType = null) use (
                    $options
                ) {
                    if (!$transactionType) {
                        return [];
                    }
                    return [
                        'data-image' => $transactionType->getCode(),
                    ];
                },
            ])
            ->add('amount', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TransactionModel::class,
        ]);
    }

}
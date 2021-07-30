<?php


namespace App\Form;


use App\Entity\Account;
use App\Entity\CustomerPurchase;
use App\Entity\Transaction;
use App\Entity\TransactionType;
use App\Model\TransactionModel;
use App\Repository\AccountRepository;
use App\Validator\AmountLessThan;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

class TransferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $exceptAccount = $options['exceptAccount'];
        $user = $options['user'];

        $builder->add('destinationAccount', EntityType::class, [
            'attr' => ['class' => 'select2',  'data-widget' => 'select2', 'data-autocomplete-url'],
            'class' => Account::class,
            'label_attr' => ['class' => 'form-control-label'],
            'query_builder' => function (AccountRepository $er) use ($user, $exceptAccount) {
                return $er->getActivesUserQb($user)->andWhere('a.id != :accountExcept')
                    ->setParameter('accountExcept', $exceptAccount);
            },
            'choice_label' => 'name',
        ])
        ;
        $builder->add('amount', NumberType::class)
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
          ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TransactionModel::class,
            'exceptAccount' => null,
            'user' => null,
        ]);
    }

}
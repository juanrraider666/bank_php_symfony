<?php


namespace App\Form;


use App\Entity\Account;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('origin', EntityType::class, [
                'label' => 'Cuenta Origen',
                'class' => Account::class,
                'placeholder' => '',
            ])
            ->add('destination', EntityType::class, [
                'label' => 'Cuenta Destino',
                'class' =>  Account::class,
                'placeholder' => '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'messages',
            'csrf_protection' => false,
            'method' => 'get',
        ]);
    }

}
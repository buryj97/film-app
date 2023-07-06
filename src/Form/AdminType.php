<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;


class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)

            ->add('firstName', TextType::class,
            ['label' => 'First Name'])

            ->add('lastName', TextType::class,
            ['label' => 'Last Name'])

            ->add('country', CountryType::class,
            ['label' => 'Your Country'])

            ->add('streamingServices', ChoiceType::class,
            ['label' => 'Your Subscriptions',
            'expanded' => true,
            'multiple' => true,
            'choices' => [
                'Netflix' => 'netflix',
                'Hulu' => 'hulu',
                'Disney Plus' => 'disney',
                'Amazon Prime Video' => 'prime',
                'HBO Max' => 'hbo',
                'Mubi' => 'mubi'
            ]
            ])

            ->add('roles', ChoiceType::class,
            ['label' => 'Roles',
            'required' => true,
            'expanded' => true,
            'multiple' => true,
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN'
            ]])

            ->add('submit', SubmitType::class,
            ['label' => 'Create User',
            'attr'=> ['class' => 'btn btn-primary col-12 mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

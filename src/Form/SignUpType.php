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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)

            ->add('password', RepeatedType::class,
            ['type' => PasswordType::class,
            'first_options' => ['label' => 'Create your password',], 'second_options' => ['label' => 'Confirm your password']])

            ->add('firstName', TextType::class,
            ['label' => 'First Name',
            'required' => true])

            ->add('lastName', TextType::class,
            ['label' => 'Last Name',
            'required' => true])

            ->add('country', CountryType::class,
            ['label' => 'Your Country',
            'required' => false])

            ->add('streamingServices', ChoiceType::class,
            ['label' => 'Your Subscriptions',
            'required' => false,
            'expanded' => true,
            'multiple' => true,
            'choices' => [
                'Netflix' => 'Netflix',
                'Hulu' => 'Hulu',
                'Disney Plus' => 'Disney Plus',
                'Amazon Prime Video' => 'Amazon Prime Video',
                'HBO Max' => 'HBO Max',
                'Mubi' => 'Mubi'
            ]
            ])

            ->add('submit', SubmitType::class,
            ['label' => 'Sign Up'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

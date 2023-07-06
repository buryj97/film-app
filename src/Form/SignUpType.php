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
            'required' => true,
            'help' => 'Warning: Your country may not be included in the film database. If this is the case, you will still be able to use the search feature, but must carry out the search using a different country. If you stream using a VPN, we recommened searching for films in the country you plan to connect your VPN service to. For a full list of countries, see the search form on the home page.'])

            ->add('streamingServices', ChoiceType::class,
            ['label' => 'Your Subscriptions',
            'required' => true,
            
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

            ->add('submit', SubmitType::class,
            ['label' => 'Sign Up',
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

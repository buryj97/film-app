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
            ->add('email', EmailType::class,
            ['required' => false,
            ])


            ->add('firstName', TextType::class,
            ['label' => 'First Name',
            'required' => false,
            ])

            ->add('lastName', TextType::class,
            ['label' => 'Last Name',
            'required' => false,
            ])

            ->add('country', CountryType::class,
            ['label' => 'Your Country',
            'required' => false,
            'choice_loader' => null,
            'choices' => [
                'Argentina' => 'Argentina',
                'Australia' => 'Australia',
                'Austria' => 'Austria',
                'Azerbaijan' => 'Azerbaijan',
                'Belgium' => 'Belgium',
                'Brazil' => 'Brazil',
                'Bulgaria' => 'Bulgaria',
                'Canada' => 'Canada',
                'Chile' => 'Chile',
                'Colombia' => 'Colombia',
                'Croatia' => 'Croatia',
                'Cyprus' => 'Cyprus',
                'Czech Republic' => 'Czech Republic',
                'Denmark' => 'Denmark',
                'Ecuador' => 'Ecuador',
                'Estonia' => 'Estonia',
                'Finland' => 'Finland',
                'France' => 'France',
                'Germany' => 'Germany',
                'Greece' => 'Greece',
                'Hong Kong' => 'Hong Kong',
                'Hungary' => 'Hungary',
                'Icelad' => 'Icelad',
                'India' => 'India',
                'Indonesia' => 'Indonesia',
                'Ireland' => 'Ireland',
                'Israel' => 'Israel',
                'Italy' => 'Italy',
                'Japan' => 'Japan',
                'Lithuania' => 'Lithuania',
                'Malaysia' => 'Malaysia',
                'Mexico' => 'Mexico',
                'Moldova' => 'Moldova',
                'Netherlands' => 'Netherlands',
                'New Zealand' => 'New Zealand',
                'North Macedonia' => 'North Macedonia',
                'Norway' => 'Norway',
                'Panama' => 'Panama',
                'Peru' => 'Peru',
                'Philippines' => 'Philippines',
                'Poland' => 'Poland',
                'Portugal' => 'Portugal',
                'Romania' => 'Romania',
                'Russia' => 'Russia',
                'Serbia' => 'Serbia',
                'Singapore' => 'Singapore',
                'South Africa' => 'South Africa',
                'South Korea' => 'South Korea',
                'Spain' => 'Spain',
                'Sweden' => 'Sweden',
                'Switzerland' => 'Switzerland',
                'Thailand' => 'Thailand',
                'Turkey' => 'Turkey',
                'Ukraine' => 'Ukraine',
                'United Emirates' => 'United Emirates',
                'United Kingdom' => 'United Kingdom',
                'United States' => 'United States',
                'Vietnam' => 'Vietnam'
            ]])

            ->add('streamingServices', ChoiceType::class,
            ['label' => 'Your Subscriptions',
            'required' => false,
            'expanded' => true,
            'multiple' => true,
            'choices' => [
                'Netflix' => 'Netflix',
                'Hulu' => 'Hulu',
                'Disney Plus' => 'Disney',
                'Amazon Prime Video' => 'Prime Video',
                'HBO Max' => 'HBO',
                'Mubi' => 'Mubi'
            ]
            ])


            ->add('roles', ChoiceType::class,
            ['label' => 'Roles',
            'required' => false,
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

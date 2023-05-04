<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;

class FilmSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('keywords', TextType::class, [
                'label' => 'Keywords',
                'required' => false
            ])
            ->add('genre', ChoiceType::class,
            ['label' => 'Genre',
            'required' => false,
            'expanded' => false,
            'multiple' => false,
            'choices' => [
                'Action' => '28',
                'Adventure' => '12',
                'Animation' => '16',
                'Biography' => '1',
                'Comedy' => '35',
                'Crime' => '80',
                'Documentary' => '99',
                'Drama' => '18',
                'Family' => '10751',
                'Fantasy' => '14',
                'History' => '36',
                'Horror' => '27',
                'Music' => '10402',
                'Musical' => '4',
                'Mystery' => '9648',
                'Romance' => '10749',
                'Science Fiction' => '878',
                'Sport' => '5',
                'Thriller' => '53',
                'War' => '10752',
                'Western' => '37'
            ]
            ])
            ->add('country', CountryType::class,
            ['label' => 'Your Country',
            'required' => false])
            ->add('language', LanguageType::class,[
            'required' => false
            ])
            ->add('streamingServices', ChoiceType::class,
            ['label' => 'Your Subscriptions (4 maximum)',
            'required' => false,
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
            ->add('submit', SubmitType::class)
        ;
    }
}

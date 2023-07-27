<?php

namespace App\Form;

use App\Repository\UserRepository;
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
            ['label' => 'Your Country *',
            'required' => true,
            'choice_loader' => null,
            'choices' => [
                'Argentina' => 'ar',
                'Australia' => 'au',
                'Austria' => 'at',
                'Azerbaijan' => 'az',
                'Belgium' => 'be',
                'Brazil' => 'br',
                'Bulgaria' => 'bg',
                'Canada' => 'ca',
                'Chile' => 'cl',
                'Colombia' => 'co',
                'Croatia' => 'hr',
                'Cyprus' => 'cy',
                'Czech Republic' => 'cz',
                'Denmark' => 'dk',
                'Ecuador' => 'ec',
                'Estonia' => 'ee',
                'Finland' => 'fi',
                'France' => 'fr',
                'Germany' => 'de',
                'Greece' => 'gr',
                'Hong Kong' => 'hk',
                'Hungary' => 'hu',
                'Icelad' => 'is',
                'India' => 'in',
                'Indonesia' => 'id',
                'Ireland' => 'ie',
                'Israel' => 'il',
                'Italy' => 'it',
                'Japan' => 'jp',
                'Lithuania' => 'lt',
                'Malaysia' => 'my',
                'Mexico' => 'mx',
                'Moldova' => 'md',
                'Netherlands' => 'nl',
                'New Zealand' => 'nz',
                'North Macedonia' => 'mk',
                'Norway' => 'no',
                'Panama' => 'pa',
                'Peru' => 'pe',
                'Philippines' => 'ph',
                'Poland' => 'pl',
                'Portugal' => 'pt',
                'Romania' => 'ro',
                'Russia' => 'ru',
                'Serbia' => 'rs',
                'Singapore' => 'sg',
                'South Africa' => 'za',
                'South Korea' => 'kr',
                'Spain' => 'es',
                'Sweden' => 'se',
                'Switzerland' => 'ch',
                'Thailand' => 'th',
                'Turkey' => 'tr',
                'Ukraine' => 'ua',
                'United Emirates' => 'ae',
                'United Kingdom' => 'gb',
                'United States' => 'us',
                'Vietnam' => 'vn'
            ],
            'preferred_choices' => ['fr', 'us', 'uk', 'ie', 'de', 'ca', 'es'] 
            ])
           
            ->add('language', LanguageType::class,[
            'required' => false,
            'label' => 'Original Language'
            ])
    
            ->add('streamingServices', ChoiceType::class,
            ['label' => 'Your Subscriptions (4 maximum) *',
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
            [
                'label' => 'Search',
                'attr'=> ['class' => 'btn btn-primary col-12 mt-3']
            ])
        ;
    }
}

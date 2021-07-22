<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('release_date', DateType::class, [
                'label' => 'Date de sortie ',
            ])
            ->add('duration', NumberType::class, [
                'label' => 'Durée en min',
                'html5' => true,
            ])
            ->add('poster', UrlType::class, [
                'label' => 'Affiche du film (lien)',
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Note sur 5',
                'placeholder' => 'Choisissez votre note ci-dessous !',
                'choices' => [
                    // Label => valeur
                    'Excellent' => 5,
                    'Très bon' => 4,
                    'Bon' => 3,
                    'Peut mieux faire' => 2,
                    'A éviter' => 1,
                ],
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'label' => 'Sélection des genres ',
                'multiple' => true,
                'expanded' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}

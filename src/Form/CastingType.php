<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Casting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CastingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', TextType::class, [
                'label' => 'Role',
            ])
            ->add('credit_order', ChoiceType::class, [
                'label' => 'Crédit Order',
                'placeholder' => 'Choisissez votre ordre pour les crédits ci-dessous !',
                'choices' => [
                    // Label => valeur
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ],
            ])
            ->add('person', EntityType::class, [
                'class' => Person::class,
                'label' => 'Sélection de la personne ',
            ])
            ->add('movie', EntityType::class, [
                'class' => Movie::class,
                'label' => 'Sélection du film ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Casting::class,
        ]);
    }
}

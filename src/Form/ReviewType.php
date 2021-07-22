<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $reactions = ["Rire", "Pleurer", "Réfléchir", "Dormir", "Rêver"];

        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Critique'
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Appréciation',
                // @link https://symfony.com/doc/current/reference/forms/types/choice.html#choices
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
            ->add('reactions', ChoiceType::class, [
                    'label' => 'Ce film vous a fait : ',
                    'choices' => [
                        'Rire' => "smile",
                        'Pleurer' => "cry",
                        'Réfléchir' => "think",
                        'Dormir' => "sleep",
                        'Rêver' => "dream",
                    ],
                    'multiple' => true,
                    'expanded' => true,
            ])
            ->add('watchedAt', DateTimeType::class, [
                'label' => 'Vous avez vu ce film le : ',
                'input' => 'datetime_immutable',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}

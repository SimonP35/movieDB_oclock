<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "E-Mail",
            ])
            ->add('roles', ChoiceType::class, [
                'label' => "Role de l'utilisateur",
                'choices' => [
                    "Utilisateur" => "ROLE_USER",
                    "Manager" => "ROLE_MANAGER",
                    "Administrateur" => "ROLE_ADMIN",
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'help' => "8 lettres, 1 chiffre et 1 caractère spécial (@$!%*#?&-\)"
                ],
                'second_options' => ['label' => 'Répéter le mot de passe'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

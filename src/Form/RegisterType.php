<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // Les add correspondent tous a des inputs/champs
        
            ->add('firstname', TextType::class, [   // Input type: ici c'est un input type="text"
                'label' => 'Votre prénom',          // label: C'est le text qui définit l'input
                'constraints' => new Length([       // constraints: ajout de contrainte sur l'input
                    'min' => 2,                     // le texte dans l'input doit etre compris entre 2
                    'max' => 30                     // et 30 caractères
                ]),
                'attr' => [                         // attr: correspond a l'ajout d'attribue comme une class, un id, ou comme ici un placeholder
                    'placeholder'  => 'Merci de saisir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder'  => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 100
                ]),
                'attr' => [
                    'placeholder'  => 'Merci de saisir votre email'
                ]
            ]) 
            ->add('password', RepeatedType::class, [   // Ce RepeatedType consiste a répéter l'input autant de fois que l'on veux
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => 'Votre mot de passe',
                'required' => true,                    // Required signifie que ce champ est obligatoire ou non
                'first_options' => [                   // Première répétition
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'placeholder'  => 'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options' => [                   // Seconde répétition
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder'  => 'Merci de confirmez votre mot de passe'
                    ]
                ]
            ])  
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

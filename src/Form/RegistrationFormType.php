<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
/*                 'attr' => [
                    'placeholder' => 'Nom d\'utilisateur'
                ], */
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',  
            ])
            ->add('email')
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'single_text',
                "label" => "Date de naissance",
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Acceptez les CGU.',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les CGU.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,

                'invalid_message' => 'Mots de passe non similaires',
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                   /*  'help' => 'The ZIP/Postal code for your credit card\'s billing address.' */
                ],
                'second_options' => ['label' => 'Répéter le mot de passe'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}

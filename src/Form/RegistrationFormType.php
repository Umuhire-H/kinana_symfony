<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\Participation;
use App\Entity\Text;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('roles', ChoiceType::class, [
            //     'label' => 'Je m\'inscris en tant que : ',
            //     'choices' => [
            //         'parent' => 'parent',
            //         'membre curieux' => 'membre',
            //         'animateur' => 'animateur',
            //         'traduteur' => 'traducteur',
            //     ],
            //     'expanded' => true,
            //     'multiple' => false,

            //     // 'mapped' => false,
            //     // 'constraints' => [
            //     //     new IsTrue([
            //     //         'message' => 'Je m\'inscris en tant que ',
            //     //     ]),
            //     // ],
            // ])
            ->add('firstName', TextType::class, [
                'placeholder' => 'Prénom'
            ])
            ->add('lastName', TextType::class)
            ->add('dateBirth', DateTimeType::class)
            
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Mot de passe manquant',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => ' {{ limit }} caractères au minimum ',
                        // max length allowed by Symfony for security reasons //--
                        'max' => 4096,
                    ]),
                ],
            ])
            // //======================================================
            // //======================================================
            // ->add('children', EntityType::class, [ //user_parent
            //     'class' => Child::class,
            //     'required' =>false]) 

            // ->add('participations', EntityType::class, [// user_single
            //     'class' => Participation::class,
            //     'required' =>false] ) 
            // ->add('requestedTexts', EntityType::class, [
            //     'class' => Text::class,
            //     'required' =>false]) 
            // ->add('translatedTexts', EntityType::class, [
            //     'class' => Text::class,
            //     'required' =>false]) 
            // ->add('activityExecutions', EntityType::class, [
            //     'class' => Text::class,
            //     'required' =>false])     
            // //======================================================
            // //======================================================
            
            // // ->add('agreeTerms', CheckboxType::class, [
            // //     'mapped' => false,
            // //     'constraints' => [
            // //         new IsTrue([
            // //             'message' => 'J\'accepte les termes.',
            // //         ]),
            // //     ],
            // // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

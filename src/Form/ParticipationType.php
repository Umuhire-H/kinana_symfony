<?php
// CECI EST MON NOUVEL ESSAI : SANS SUCCES NON PLUS
namespace App\Form;

use App\Entity\Child;
use App\Entity\Participation;
use App\Entity\ActivityExecution;
use App\Entity\User;
use App\Repository\ChildRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\ActivityExecutionRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Currency;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function($aUser){
                    return $aUser->getUsername();
                }, 
            ])
            ->add('activityExecution', EntityType::class, [
                'class' => ActivityExecution::class,/*
                'query_builder' => function (ActivityExecutionRepository $repo){
                    return $repo->createQueryBuilder('ae');
                },*/
                'data' => $options['selectedActivity'],
               // 'label' => $options['selectedActivity']->getActivity()->getName().' du '.getDate()->format('d-m-Y'),
                'choice_label' => function($ActEx){
                    return $ActEx->getActivity()->getName().' du '.$ActEx->getDate()->format('d-m-Y');
                },                
            ])            
            ->add('child', EntityType::class, [
                'class' => Child::class/*,
                'query_builder' => function (ChildRepository $repo){
                    return $repo->createQueryBuilder('c');
                }*/,
                'choices' => $options['user']->getChildren(),
                'choice_label' => function($child){
                    return $child->getFirstName();
                },
                'required' => false

            ])
            ->add('typePayement', ChoiceType::class,[//select
                'choices' => [
                    'cash' => 'cash',
                    'paypal' => 'paypal',
                ],
                'expanded' => false,
                'multiple' => false,
                
            ])
            ->add('datePayement', DateTimeType::class, [
                'label' => 'Date de Payement',
                'required' => false
            ])
            ->add('pricePayed', MoneyType::class, [
                'disabled' => true,
                'currency' => false,
                'required' => false                
            ]
            )
            ->add('statusPayement', ChoiceType::class, [ //radio
                'choices' => [
                    'in process' => 'en cours',
                    'payed' => 'payé',
                    'unpayed' => 'non payé',
                ],
                'expanded' => true,
                'multiple' => false
                
            ])
            ->add('comment', TextType::class, [
                'required' => false
            ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
            'user' => null,
            'selectedActivity' =>null,
        ]);
    }
}

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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
        ->add('target', ChoiceType::class,[
            'mapped' => false,
            //'label' => 'Cette inscription concerne',
            'choices' => [
                // 'Moi-même' => $options['user']->getId(),
                'J\'inscris mon enfant' => false,
                'Je m\'inscris' => true,
                
            ],
            'placeholder' => false,
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
                'required' => false,
                'placeholder' => 'Aucun enfant sélectionné '
            
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function($aUser){
                    return $aUser->getId() .' - '.$aUser->getUsername();
                },
                'required' => false,
                 
            ])
            ->add('activityExecution', EntityType::class, [
                'class' => ActivityExecution::class,
                'query_builder' => function (ActivityExecutionRepository $repo) use ($options){
                    return $repo->createQueryBuilder('ae')
                                ->select('ae')
                                ->where('ae.id = :id')
                                // ->setParameter('id', ($options['selectedActivity']->getId()));
                                ->setParameter('id', $options['selectedActivity']);
                },
               
               'choice_label' => function($ActEx){
                   return $ActEx->getActivity()->getName().' du '.$ActEx->getDate()->format('d-m-Y');
                },   
               'placeholder' => false,   
                         
            ])            
            ->add('typePayement', ChoiceType::class,[//select
                'choices' => [
                    'cash' => 'cash',
                    'paypal' => 'paypal',
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Choix de playement'
                
            ])
            ->add('datePayement', DateTimeType::class, [
                'label' => 'Date de Payement',
                'required' => false
            ])
            ->add('pricePayed', MoneyType::class, [
                'disabled' => true,
                'currency' => false,
                'required' => false,           
                // 'data' => function() use ($options){

                //     return (int)($options['selectedActivity']->getActivity()->getPrice());
                // },   
                            
            ]
            )
            ->add('statusPayement', ChoiceType::class, [ //radio
                'choices' => [
                    'in process' => 'en cours',
                    'payed' => 'payé',
                    'unpayed' => 'non payé',
                    /* 
                    'en cours' => 'in process',
                    'payé' => 'payed',
                    'non payé' => 'unpayed',
                    */
                ],
                'expanded' => true,
                'multiple' => false, 
                'required' => false,
                
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

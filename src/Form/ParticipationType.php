<?php
// CECI EST MON NOUVEL ESSAI : SANS SUCCES NON PLUS
namespace App\Form;

use App\Entity\Participation;
use App\Entity\ActivityExecution;
use App\Repository\ActivityExecutionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePayement', DateTimeType::class)
            ->add('pricePayed', MoneyType::class)
            ->add('typePayement', ChoiceType::class,[//select
                'choices' => [
                    'cash' => 'cash',
                    'paypal' => 'paypal',
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true
            ])
            ->add('statusPayement', ChoiceType::class, [ //radio
                'choices' => [
                    'en cours' => 'en cours',
                    'payé' => 'payé',
                    'non payé' => 'non payé',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('comment', TextType::class)
            ->add('activityExecution', EntityType::class, [
                'class' => ActivityExecution::class,
                'query_builder' => function (ActivityExecutionRepository $repo){
                    return $repo->createQueryBuilder('ae');
                },
                'choice_label' => function($ActEx){
                    return $ActEx->getActivity()->getName();
                }
            ]);
            // ->add('user')
            // ->add('child')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}

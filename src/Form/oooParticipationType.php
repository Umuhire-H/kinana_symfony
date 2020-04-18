
<?php
/*
namespace App\Form;

use App\Entity\ActivityExecution;
use App\Entity\Child;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class ParticipationType extends AbstractType {
    public function buildForm (FormBuilderInterface $builder, array $options){
        $builder
        ->add ('child', EntityType::class, 
            ['class'=> Child::class])
        ->add ('user', EntityType::class,
             ['class'=> User::class])
        ->add ('activityExecution', EntityType::class,
             ['class'=> ActivityExecution::class])
        ->add ('pricePayed', MoneyType::class)
        ->add ('typePayement', ChoiceType::class, 
            ['choices'  => [
                'cash' => 'cash',
                'paypal' => 'paypal',
            ]
            ])
        ->add ('statusPayement', ChoiceType::class,
             ['choices'  => [
                'En cours' => null,
                'Payé' => true,
                'Non payé' => false,
            ],
             ])
        ->add ('datePayement', DateTimeType::class);
    }   
} 

*/
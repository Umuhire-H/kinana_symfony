<?php
// CECI EST MON NOUVEL ESSAI : SANS SUCCES NON PLUS
namespace App\Form;

use App\Entity\Participation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePayement')
            ->add('pricePayed')
            ->add('typePayement')
            ->add('statusPayement')
            ->add('comment')
            ->add('activityExecution')
            ->add('user')
            ->add('child')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}

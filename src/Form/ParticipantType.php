<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom')
        ->add('email')
        ->add('is_subscribe')
        ->add('fonction')
        ->add('Formation',EntityType::class,[
            'class' => Formation::class,
            'choice_label' =>'titre',
        ])
        ->add('image')
        ->add('valider',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}

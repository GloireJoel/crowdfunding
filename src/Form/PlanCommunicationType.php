<?php

namespace App\Form;

use App\Entity\PlanCommunication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanCommunicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objectif', TextType::class,  [
                'label' => 'Objectif'
            ])
            ->add('cible', TextType::class,  [
                'label' => 'Cible'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanCommunication::class,
        ]);
    }
}

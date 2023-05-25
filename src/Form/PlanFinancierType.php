<?php

namespace App\Form;

use App\Entity\PlanFinancier;
use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanFinancierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motif', TextType::class,  [
                'label' => 'Motif'
            ])
            ->add('montant', NumberType::class,  [
                'label' => 'Montant'
            ])
            ->add('projet', EntityType::class,[
                    'label' => 'Projet',
                    'class' => Projet::class,
                    'query_builder' => function (ProjetRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.titre', 'ASC');
                    }, 'choice_label' => 'titre']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanFinancier::class,
        ]);
    }
}

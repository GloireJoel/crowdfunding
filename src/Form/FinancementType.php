<?php

namespace App\Form;

use App\Entity\Financement;
use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinancementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('projet', EntityType::class,[
                    'label' => 'Projet',
                    //'multiple' => true,
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
            'data_class' => Financement::class,
        ]);
    }
}

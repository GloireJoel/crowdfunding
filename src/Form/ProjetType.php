<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Projet;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('categorie', EntityType::class,[
                'label' => 'Categorie',
                'class' => Categorie::class,
                'query_builder' => function (CategorieRepository $er) {
                return $er->createQueryBuilder('u')
                ->orderBy('u.name', 'ASC');
                }, 'choice_label' => 'name']
            )
            ->add('date_debut', DateType::class)
            ->add('date_fin', DateType::class)
            ->add('objet', TextType::class)
            ->add('pourquoi', TextType::class)
            ->add('histoire', TextareaType::class)
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}

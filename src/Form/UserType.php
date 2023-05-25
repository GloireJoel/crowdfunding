<?php

namespace App\Form;

use App\Entity\Roles;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'F' => 'F',
                    'M' => 'M'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('localisation', TextType::class, [
                'label' => 'Localisation'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false
            ])
            ->add('roles', ChoiceType::class,[
                'label' => 'Roles',
                'required' => true,
                'choices' => [
                    'Porteur de Projet' => Roles::PROJECT_OWNER,
                    'Investisseur' => Roles::INVESTOR
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

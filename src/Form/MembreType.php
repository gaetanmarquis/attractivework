<?php

namespace App\Form;

use App\Entity\Membre;
use App\Entity\Personnalite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation de mot de passe',
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Photo de profil',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('personnalite', EntityType::class, [
                'label' => 'Personnalite',
                'class' => Personnalite::class,
                'choice_label' => 'nom',
            ])
            ->add('role_emploi', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [
                    'Candidat' => 'candidat',
                    'Recruteur' => 'recruteur'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}

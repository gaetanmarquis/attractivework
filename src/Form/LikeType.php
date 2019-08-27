<?php

namespace App\Form;

use App\Entity\Like;
use App\Entity\Candidat;
use App\Entity\Recruteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('candidat', AutocompleteType::class, [
                'class' => Candidat::class,
                'label' => "id candidat"
            ])
            ->add('recruteur', AutocompleteType::class, [
                'class' => Recruteur::class,
                'label' => "id recruteur"
            ])
            ->add('role_like', ChoiceType::class, [
                'label' => 'Role',
                'choices' => [
                    'Candidat' => 'candidat',
                    'Recruteur' => 'recruteur',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>"Ajouter un like"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Like::class,
        ]);
    }
}

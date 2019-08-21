<?php

namespace App\Form;

use App\Entity\Match;
use App\Entity\Candidat;
use App\Entity\Recruteur;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_match', DateType::class, [
                'label'=>"Date du match"
            ])
            ->add('candidat', AutocompleteType::class, [
                'class' => Candidat::class,
                'label' => "id candidat"
            ])
            ->add('recruteur', AutocompleteType::class, [
                'class' => Recruteur::class,
                'label' => "id recruteur"
            ])
            ->add('submit', SubmitType::class, [
                'label'=>"Ajouter un match"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Match::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Entity\Like;
use App\Entity\Recruteur;
use Symfony\Component\Form\AbstractType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

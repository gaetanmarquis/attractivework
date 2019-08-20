<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description_poste', TextType::class, [
                'label' => 'Description du poste'
            ])
            ->add('salaire_poste', TextType::class, [
                'label' => 'Salaire'
            ])
            ->add('ville_poste', TextType::class, [
                'label' => 'Ville du poste'
            ])
            ->add('pays_poste', TextType::class, [
                'label' => 'Pays du poste'
            ])
            ->add('date_publication', DateType::class, [
                'label' => 'Date de publication'
            ])
            ->add('recruteur', TextType::class, [
                'label' => 'Recruteur'
            ])

            ->add('submit', SubmitType::class,[
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}

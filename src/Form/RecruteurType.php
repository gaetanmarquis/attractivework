<?php

namespace App\Form;

use App\Entity\Recruteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RecruteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_entreprise', TextType::class, [
                'label' => 'Nom de l\'entreprise',
            ])
            ->add('secteur_activite', TextType::class, [
                'label' => 'Secteur d\'activité',
            ])
            ->add('logo_entreprise', FileType::class, [
                'label' => 'Logo entreprise',
                'data_class' => null,
            ])
            ->add('nbr_employe', IntegerType::class, [
                'label' => 'Nombre d\'employés',
            ])
            /*
            ->add('membre')
            */
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recruteur::class,
        ]);
    }
}

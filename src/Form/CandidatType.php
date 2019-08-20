<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_naissance', DateType::class, [
                'label' => 'Date de naissance',
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone',
            ])
            ->add('cv', FileType::class, [
                'label' => 'CV',
            ])
            ->add('autre_fichier', FileType::class, [
                'label' => 'Autre fichier',
            ])
            ->add('atout', TextType::class, [
                'label' => 'Atout',
            ])
            ->add('site_web', UrlType::class, [
                'label' => 'Site web',
            ])
            ->add('salaire', MoneyType::class, [
                'label' => 'Salaire',
            ])
            ->add('date_disponibilite', DateType::class, [
                'label' => 'Date de disponibilité',
            ])
            ->add('type_contrat', ChoiceType::class, [
                'label' => 'Type de contrat',
                'choices' => [
                    'CDD' => 'CDD',
                    'CDI' => 'CDI',
                    'Alternance' => 'alternance',
                    'Stage' => 'stage',
                    'Interim' => 'interim',
                ]
            ])
            ->add('metier', TextType::class, [
                'label' => 'Métier',
            ])
            ->add('annee_experience', IntegerType::class, [
                'label' => 'Années d\'expérience',
            ])
            ->add('langue_parlee', TextType::class, [
                'label' => 'Langues parlées',
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
            'data_class' => Candidat::class,
        ]);
    }
}

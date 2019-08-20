<?php

namespace App\Form;

use App\Entity\Personnalite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PersonnaliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom'
        ])
            ->add('reference', TextType::class, ['label' => 'Référence'
        ])
            ->add('categorie', TextType::class, ['label' => 'Catégorie'
        ])
            ->add('description', TextareaType::class, ['label' => 'Description'
        ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnalite::class,
        ]);
    }
}

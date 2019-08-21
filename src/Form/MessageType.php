<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Candidat;
use App\Entity\Recruteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('candidat', AutocompleteType::class, ['label' => 'Candidat:'
        ]) 
            ->add('recruteur', AutocompleteType::class, ['label' => 'Recruteur:'
        ])
            ->add('message', TextareaType::class, ['label' => 'Message'
        ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}

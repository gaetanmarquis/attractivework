<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Mdp extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Le mot de passe "{{ value }}" doit contenir un chiffre, une lettre majuscule et 8 caractères minimum.';
}

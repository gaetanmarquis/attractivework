<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPersoRecruteurController extends AbstractController
{
    /**
     * @Route("/profil/perso/recruteur", name="profil_perso_recruteur")
     */
    public function index()
    {
        return $this->render('profil_perso_recruteur/index.html.twig', [
            'controller_name' => 'ProfilPersoRecruteurController',
        ]);
    }
}

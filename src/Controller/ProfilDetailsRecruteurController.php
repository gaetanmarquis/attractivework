<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilDetailsRecruteurController extends AbstractController
{
    /**
     * @Route("/profil/details/recruteur", name="profil_details_recruteur")
     */
    public function index()
    {
        return $this->render('profil_details_recruteur/index.html.twig', [
            'controller_name' => 'ProfilDetailsRecruteurController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPersoCandidatController extends AbstractController
{
    /**
     * @Route("/profil/perso/candidat", name="profil_perso_candidat")
     */
    public function index()
    {
        return $this->render('profil_perso_candidat/index.html.twig', [
            'controller_name' => 'ProfilPersoCandidatController',
        ]);
    }
}

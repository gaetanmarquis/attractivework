<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavbarRecruteurController extends AbstractController
{
    /**
     * @Route("/navbar/recruteur", name="navbar_recruteur")
     */
    public function index()
    {
        return $this->render('navbar_recruteur/index.html.twig', [
            'controller_name' => 'NavbarRecruteurController',
        ]);
    }
}


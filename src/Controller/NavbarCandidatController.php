<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavbarCandidatController extends AbstractController
{
    /**
     * @Route("/navbar/candidat", name="navbar_candidat")
     */
    public function index()
    {
        return $this->render('navbar_candidat/index.html.twig', [
            'controller_name' => 'NavbarCandidatController',
        ]);
    }
}

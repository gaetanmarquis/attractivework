<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OffreFrontController extends AbstractController
{
    /**
     * @Route("/offre/offres-emploi", name="offre_emploi")
     */
    public function index()
    {
        return $this->render('offre_front/index.html.twig', [
            'controller_name' => 'OffreFrontController',
        ]);
    }
}

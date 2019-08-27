<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OffreDetailController extends AbstractController
{
    /**
     * @Route("/offre/offres-detail", name="offre_detail")
     */
    public function index()
    {
        return $this->render('offre_detail/index.html.twig', [
            'controller_name' => 'OffreDetailController',
        ]);
    }
}

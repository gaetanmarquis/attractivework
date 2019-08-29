<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonnaliteFrontController extends AbstractController
{
    /**
     * @Route("/types-de-personnalite", name="types-de-personnalite")
     */
    public function index()
    {
        return $this->render('personnalite_front/index.html.twig', [
            'controller_name' => 'PersonnaliteFrontController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\PersonnaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonnaliteFrontController extends AbstractController
{
    /**
     * @Route("/types-de-personnalite", name="types-de-personnalite")
     */
    public function index( PersonnaliteRepository $personnaliteRepository )
    {

        $personnalites = $personnaliteRepository->findAll();
        return $this->render('personnalite_front/index.html.twig', [
            'personnalites' => $personnalites,
        ]);
    }
}

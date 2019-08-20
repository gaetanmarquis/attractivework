<?php

namespace App\Controller;

use App\Repository\PersonnaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonnaliteController extends AbstractController
{
    /**
     * @Route("/personnalite", name="personnalite")
     */
    public function index ( PersonnaliteRepository $personnaliteRepository)
    {
        $personnalites = $personnaliteRepository->findAll();
        return $this->render('personnalite/index.html.twig', [
            'personnalites' => $personnalites,
        ]);
    }
}

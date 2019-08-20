<?php

namespace App\Controller;

use App\Repository\RecruteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecruteurController extends AbstractController
{
    /**
     * @Route("/recruteur", name="recruteur")
     */
    public function index(RecruteurRepository $recruteurRepository)
    {
        $recruteurs = $recruteurRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();
        return $this->render('recruteur/index.html.twig', [
            'recruteurs' => $recruteurs,
        ]);
    }
}

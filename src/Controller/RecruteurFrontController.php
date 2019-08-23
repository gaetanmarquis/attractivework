<?php

namespace App\Controller;

use App\Repository\RecruteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecruteurFrontController extends AbstractController
{
    /**
     * @Route("/recruteur/profil", name="recruteur_front")
     */
    public function index(RecruteurRepository $recruteurFrontRepository)
    {
        $recruteurs = $recruteurFrontRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();
        return $this->render('recruteur_front/index.html.twig', [
            'recruteurs' => $recruteurs,
        ]);
    }
}

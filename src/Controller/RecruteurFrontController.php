<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecruteurFrontController extends AbstractController
{
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/recruteur/profil", name="recruteur_front")
     */
    public function index(CandidatRepository $candidatRepository)
    {
        $candidats = $candidatRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();
        return $this->render('recruteur_front/index.html.twig', [
            'candidats' => $candidats,
        ]);
    }
}


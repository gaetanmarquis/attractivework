<?php

namespace App\Controller;

use App\Repository\RecruteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilCandidatController extends AbstractController
{
    /**
     * @Route("/accueil/candidat", name="accueil_candidat")
     */
    public function index( RecruteurRepository $recruteurRepository)
    {

    	$recruteurs = $recruteurRepository->createQueryBuilder('r')
    	->join('r.membre', 'm')
    	->addSelect('m')
    	->getQuery()
    	->getResult();

        return $this->render('accueil_candidat/index.html.twig', [
            'recruteurs' => $recruteurs,
        ]);
    }
}

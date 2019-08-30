<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use App\Repository\PersonnaliteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonnaliteFrontController extends AbstractController
{
    /**
     * @Route("/types-de-personnalite", name="types-de-personnalite")
     */
    public function index( 
        PersonnaliteRepository $personnaliteRepository,
        CandidatRepository $candidatRepository, 
        RecruteurRepository $recruteurRepository )
    {

        $membre = $this->getUser();

        if( $membre->getRoleEmploi() === 'candidat' ){
            $candidat = $candidatRepository->createQueryBuilder('c')
                ->join('c.membre', 'm')
                ->addSelect('m')
                ->where('c.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $idUser = $candidat[0]->getId();
        }
        elseif( $membre->getRoleEmploi() === 'recruteur' ){
            $recruteur = $recruteurRepository->createQueryBuilder('r')
                ->join('r.membre', 'm')
                ->addSelect('m')
                ->where('r.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $idUser = $recruteur[0]->getId();
        }

        $personnalites = $personnaliteRepository->findAll();
        return $this->render('personnalite_front/index.html.twig', [
            'personnalites' => $personnalites,
            'idUser' => $idUser,
            'role' => $membre->getRoleEmploi(),
        ]);
    }
}

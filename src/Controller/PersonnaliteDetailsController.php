<?php

namespace App\Controller;

use App\Entity\Personnalite;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use App\Repository\PersonnaliteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonnaliteDetailsController extends AbstractController
{
    /**
     * @Route("/personnalite/details/{id}/{role}", name="personnalite_details")
     */
    public function index( 
        PersonnaliteRepository $personnaliteRepository, 
        CandidatRepository $candidatRepository, 
        RecruteurRepository $recruteurRepository, 
        int $id, 
        string $role)
    {

        $personnalite = $personnaliteRepository->find($id);
        
        $membre = $this->getUser();

        if( $membre->getRoleEmploi() === 'candidat' ){
            $candidat = $candidatRepository->createQueryBuilder('c')
                ->join('c.membre', 'm')
                ->addSelect('m')
                ->where('c.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $recruteur[0] = $recruteurRepository->find($id);

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

            $candidat[0] = $candidatRepository->find($id);

            $idUser = $recruteur[0]->getId();
        }

        return $this->render('personnalite_details/index.html.twig', [
            'personnalite' => $personnalite,
            'role' => $role,
            'idUser' => $idUser,
        ]);
    }
}

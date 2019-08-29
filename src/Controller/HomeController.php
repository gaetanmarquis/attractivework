<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecruteurRepository;
use App\Repository\CandidatRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( RecruteurRepository $recruteurRepository, CandidatRepository $candidatRepository)
    {
        $role = null;
        $id = null;

        if($this->getUser() !== null){
            $role = $this->getUser()->getRoleEmploi();
            
            if( $role === 'recruteur' ){
                $recruteur = $recruteurRepository->createQueryBuilder('r')
                    ->join('r.membre', 'm')
                    ->addSelect('m')
                    ->where('r.membre = :membre')
                    ->setParameter('membre', $this->getUser())
                    ->getQuery()
                    ->getResult();

                $id = $recruteur[0]->getId();
            }
            elseif( $role === 'candidat' ){
                $candidat = $candidatRepository->createQueryBuilder('c')
                    ->join('c.membre', 'm')
                    ->addSelect('m')
                    ->where('c.membre = :membre')
                    ->setParameter('membre', $this->getUser())
                    ->getQuery()
                    ->getResult();

                $id = $candidat[0]->getId();
            }
        }

        return $this->render('home/index.html.twig', [
            'role' => $role,
            'id' => $id,
        ]);
    }
}

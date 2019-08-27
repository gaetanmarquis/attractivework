<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Repository\RecruteurRepository;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilDetailsRecruteurController extends AbstractController
{
    /**
     * @Route("/profil/details/recruteur/{id}", name="profil_details_recruteur")
     */
    public function index( RecruteurRepository $recruteurRepository, int $id )
    {

    	$recruteur = $recruteurRepository->createQueryBuilder('r')
    	->where('r.id = :id')
    	->setParameter('id', $id)
    	->join('r.membre', 'm')
    	->addSelect('m')
        ->join('m.personnalite', 'p')
        ->addSelect('p')
    	->getQuery()
    	->getResult();

        return $this->render('profil_details_recruteur/index.html.twig', [
            'recruteur' => $recruteur[0],
        ]);
    }
}

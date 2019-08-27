<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Repository\CandidatRepository;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilDetailsCandidatController extends AbstractController
{
    /**
     * @Route("/profil/details/candidat/{id}", name="profil_details_candidat")
     */
    public function index( CandidatRepository $candidatRepository, int $id )
    {

    	$candidat = $candidatRepository->createQueryBuilder('c')
    	->where('c.id = :id')
    	->setParameter('id', $id)
    	->join('c.membre', 'm')
    	->addSelect('m')
        ->join('m.personnalite', 'p')
        ->addSelect('p')
    	->getQuery()
    	->getResult();
    	
        return $this->render('profil_details_candidat/index.html.twig', [
            'candidat' => $candidat[0],
        ]);
    }
}

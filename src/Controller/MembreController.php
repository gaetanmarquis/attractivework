<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembreController extends AbstractController
{
    /**
     * URL et nom de la route
     * @Route("/membre", name="membre")
     */
    public function index(MembreRepository $membreRepository)
    {
        /* 
            SELECT * FROM membre
            $membres = $membreRepository->findAll()
        */

        /*
            SELECT * FROM membre AS m
            INNER JOIN personnalite AS p
                ON m.personnalite = p.id
        */
        $membres = $membreRepository->createQueryBuilder('m')
        ->join('m.personnalite', 'p')
        ->addSelect('p')
        ->getQuery()
        ->getResult();

        // Affichage des membres
        return $this->render('membre/index.html.twig', [
            'membres' => $membres,
        ]);
    }
}

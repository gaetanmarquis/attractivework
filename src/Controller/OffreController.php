<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="offre")
     */
    public function index(OffreRepository $offreRepository)
    {
        /**  SELECT * FROM offre
         * $recruteurs = $recruteurRepository->findAll()
         */

        /**
         * SELECT * FROM offre AS o
         * INNER JOIN id AS r
         * ON r.id = r.id
         */
        $offres = $offreRepository->createQueryBuilder('o')
            ->join('o.recruteur', 'r')
            ->addSelect('r')
            ->getQuery()
            ->getResult();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }


}

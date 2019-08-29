<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OffreDetailController extends AbstractController
{
    /**
     * @Route("/offre/offres-detail", name="offre_detail")
     */
    public function index(OffreRepository $offreRepository)
    {
        $offresDetail = $offreRepository->createQueryBuilder('o')
            ->join('o.recruteur', 'r')
            ->addSelect('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();

        return $this->render('offre_detail/index.html.twig', [
            'offresDetail' => $offresDetail[0],
        ]);
    }
}

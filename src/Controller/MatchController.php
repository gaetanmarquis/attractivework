<?php

namespace App\Controller;

use App\Repository\MatchRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchController extends AbstractController
{
    /**
     * @Route("/match", name="match")
     */
    public function index( MatchRepository $matchRepository)
    {
        /*
            SELECT * FROM match AS m
            INNER JOIN candidat AS c
                ON m.candidat = c.id
            INNER JOIN membre AS mem1
                ON c.membre = mem1.id
            INNER JOIN recruteur AS r
                ON m.recruteur = r.id
            INNER JOIN membre AS mem2
                ON r.membre = mem2.id
        */
        $matchs = $matchRepository->createQueryBuilder('m')
        ->join('m.candidat', 'c')
        ->addSelect('c')
        ->join('c.membre', 'mem1')
        ->addSelect('mem1')
        ->join('m.recruteur', 'r')
        ->addSelect('r')
        ->join('r.membre', 'mem2')
        ->addSelect('mem2')
        ->getQuery()
        ->getResult();

        return $this->render('match/index.html.twig', [
            'matchs' => $matchs,
        ]);
    }
}

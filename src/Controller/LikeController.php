<?php

namespace App\Controller;

use App\Repository\LikeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    /**
     * @Route("/like", name="like")
     */
    public function index(LikeRepository $likeRepository)
    {
        /*
            SELECT * FROM like AS l
            INNER JOIN candidat AS c
                ON l.candidat = c.id
            INNER JOIN membre AS mem1
                ON c.membre = mem1.id
            INNER JOIN recruteur AS r
                ON l.recruteur = r.id
            INNER JOIN membre AS mem2
                ON r.membre = mem2.id
        */
        $likes = $likeRepository->createQueryBuilder('l')
        ->join('l.candidat', 'c')
        ->addSelect('c')
        ->join('c.membre', 'mem1')
        ->addSelect('mem1')
        ->join('l.recruteur', 'r')
        ->addSelect('r')
        ->join('r.membre', 'mem2')
        ->addSelect('mem2')
        ->getQuery()
        ->getResult();

        return $this->render('like/index.html.twig', [
            'likes' => $likes,
        ]);
    }
}

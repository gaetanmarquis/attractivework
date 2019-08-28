<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeCandidatFrontController extends AbstractController
{
    /**
     * @Route("/candidat/like/page", name="like_candidat_front")
     */
    public function index(LikeRepository $likeRepository, CandidatRepository $candidatRepository)
    {
        $membre = $this->getUser();

        $candidat = $candidatRepository->createQueryBuilder('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->where('c.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();

        $likes = $likeRepository->createQueryBuilder('l')
            ->join('l.recruteur', 'r')
            ->addSelect('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->where('l.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->getQuery()
            ->getResult();

        // dump($candidat[0]);
        // dump($likes);

        //like.recruteur.membre.nom

        return $this->render('like_candidat_front/index.html.twig', [
            'likes' => $likes,
            'candidat' => $candidat[0],
        ]);
    }
}

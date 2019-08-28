<?php

namespace App\Controller;

use App\Repository\LikeRepository;
use App\Repository\RecruteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeRecruteurFrontController extends AbstractController
{
    /**
     * @Route("/recruteur/like/page", name="like_recruteur_front")
     */
    public function index(LikeRepository $likeRepository, RecruteurRepository $recruteurRepository)
    {
        $membre = $this->getUser();

        $recruteur = $recruteurRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->where('r.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();

        $likes = $likeRepository->createQueryBuilder('l')
            ->join('l.candidat', 'c')
            ->addSelect('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->where('l.recruteur = :recruteur')
            ->setParameter('recruteur', $recruteur)
            ->getQuery()
            ->getResult();

        //like.candidat.membre.nom

        return $this->render('like_recruteur_front/index.html.twig', [
            'likes' => $likes,
            'recruteur' => $recruteur[0],
        ]);
    }
}

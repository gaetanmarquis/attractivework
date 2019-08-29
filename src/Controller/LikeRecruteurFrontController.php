<?php

namespace App\Controller;

use App\Repository\LikeRepository;
use App\Repository\MatchRepository;
use App\Repository\RecruteurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class LikeRecruteurFrontController extends AbstractController
{
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/recruteur/like/page", name="like_recruteur_front")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(LikeRepository $likeRepository, RecruteurRepository $recruteurRepository, MatchRepository $matchRepository)
    {
        $membre = $this->getUser();

        $recruteur = $recruteurRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->where('r.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getOneOrNullResult();
// like du recruteur dont le candidat a liké le recruteur
        //Where l.recruteur = recruteur
        // Join candidat
        // join candidat.likes
        // join candidat.likes.recruteur
        // where candidat.likes.recruteur = recruteur
        $matchs = $matchRepository->createQueryBuilder('ma')
            ->join('ma.candidat', 'c')
            ->addSelect('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->where('ma.recruteur = :recruteur')
            ->setParameter('recruteur', $recruteur)
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


        return $this->render('like_recruteur_front/index.html.twig', [
            'likes' => $likes,
            'matchs' => $matchs,
            'recruteur' => $recruteur,
        ]);
    }
}

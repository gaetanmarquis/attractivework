<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use App\Repository\LikeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeCandidatFrontController extends AbstractController
{
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/candidat/like/page", name="like_candidat_front")
     * @throws \Doctrine\ORM\NonUniqueResultException
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
            ->getOneOrNullResult();

        // like du candidat dont le recruteur a liké le candidat
        //Where l.candidat = candidat
        // Join recruteur
        // join recruteur.likes
        // join recruteur.likes.candidat
        // where recruteur.likes.candidat = candidat
        $match = $likeRepository->createQueryBuilder('l')
            ->join('l.recruteur', 'r')
            ->join('r.likes', 'l2')
            ->addSelect('r')
            ->where('l.candidat = :candidat AND l2.candidat = :candidat')
            ->setParameter('candidat', $candidat);

        $likes = $likeRepository->createQueryBuilder('l')
            ->join('l.candidat', 'r')
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
            'matchs' => $match,
            'candidat' => $candidat,
        ]);
    }
}

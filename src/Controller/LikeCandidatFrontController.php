<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use App\Repository\LikeRepository;
use App\Repository\MatchRepository;
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
    public function index(LikeRepository $likeRepository, CandidatRepository $candidatRepository, MatchRepository $matchRepository)
    {
        $membre = $this->getUser();

        $candidat = $candidatRepository->createQueryBuilder('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->where('c.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();

        if($candidat !== []){
            $id = $candidat[0]->getId();
        }
        else{
            $id = $membre->getId();
        }

        // like du candidat dont le recruteur a liké le candidat
        //Where l.candidat = candidat
        // Join recruteur
        // join recruteur.likes
        // join recruteur.likes.candidat
        // where recruteur.likes.candidat = candidat
        $match = $matchRepository->createQueryBuilder('ma')
            ->join('ma.recruteur', 'r')
            ->addSelect('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->where('ma.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->getQuery()
            ->getResult();

        $likes = $likeRepository->createQueryBuilder('l')
            ->join('l.candidat', 'c')
            ->addSelect('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->where('l.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->andwhere('l.role_like = :role')
            ->setParameter('role', 'candidat')
            ->getQuery()
            ->getResult();

        $likesRecruteur = $likeRepository->createQueryBuilder('l')
            ->join('l.candidat', 'c')
            ->addSelect('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->where('l.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->andwhere('l.role_like = :role')
            ->setParameter('role', 'recruteur')
            ->getQuery()
            ->getResult();

        // dump($candidat[0]);
        // dump($likes);

        //like.recruteur.membre.nom

        return $this->render('like_candidat_front/index.html.twig', [
            'likes' => $likes,
            'likesRecruteur' => $likesRecruteur,
            'matchs' => $match,
            'candidat' => $candidat,
        ]);
    }
}

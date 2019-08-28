<?php

namespace App\Controller;

use App\Repository\LikeRepository;
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
    public function index(LikeRepository $likeRepository, RecruteurRepository $recruteurRepository)
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
        $match = $likeRepository->createQueryBuilder('l')
            ->join('l.candidat', 'c')
            ->join('c.likes', 'l2')
            ->addSelect('c')
            ->where('l.recruteur = :recruteur AND l2.recruteur = :recruteur')
            ->setParameter('recruteur', $recruteur);
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
            'matchs' => $match,
            'recruteur' => $recruteur,
        ]);
    }
}

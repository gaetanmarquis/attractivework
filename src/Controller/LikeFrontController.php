<?php

namespace App\Controller;

use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeFrontController extends AbstractController
{
    /**
     * @Route("/likerecruteur/page/", name="like_recruteur_front")
     */
    public function index(LikeRepository $likeRepository)
    {

        return $this->render('like_recruteur_front/index.html.twig', [
//            'likes' => $likes,
        ]);
    }
}

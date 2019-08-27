<?php

namespace App\Controller;

use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeFrontController extends AbstractController
{
    /**
     * @Route("/like/page", name="like_front")
     */
    public function index(LikeRepository $likeRepository)
    {

        return $this->render('like_front/index.html.twig', [
//            'likes' => $likes,
        ]);
    }
}

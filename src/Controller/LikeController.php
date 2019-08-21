<?php

namespace App\Controller;

use App\Entity\Like;
use App\Form\LikeType;
use App\Repository\LikeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
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
    /*
         Adapter l'URL et le nom de la route selon la table en BDD
         Penser à faire tous les use
     */

    /**
     * @Route("/like/add", name="like_add")
     */
    public function add(Request $request, ObjectManager $objectManager)
    {
        //Adapter les 3 lignes ci-dessous selon la table en BDD
        //Il s'agit de la création du formulaire
        $like = new Like();
        $likeForm = $this->createForm(LikeType::class, $like);
        $likeForm->handleRequest($request);

        //A la soumission du formulaire
        if( $likeForm->isSubmitted() && $likeForm->isValid() ){
            //Pour les champs de type DateTime, utiliser le setter() avec comme argument new \DateTime
            $like->setDateLike( new \DateTime() );

            //Injection en BDD
            $objectManager->persist($like);
            $objectManager->flush();

            //Redirection vers l'affichage - Mettre en argument le nom de la route
            return $this->redirectToRoute('like');
        }

        //Rendu du formulaire
        return $this->render('like/add.html.twig', [
            'like_form' => $likeForm->createView(),
        ]);
    }

}


<?php

namespace App\Controller;

use App\Entity\Match;
use App\Form\MatchType;
use App\Repository\MatchRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchController extends AbstractController
{
    /**
     * @Route("/match", name="match")
     */
    public function index( MatchRepository $matchRepository)
    {
        /*
            SELECT * FROM match AS m
            INNER JOIN candidat AS c
                ON m.candidat = c.id
            INNER JOIN membre AS mem1
                ON c.membre = mem1.id
            INNER JOIN recruteur AS r
                ON m.recruteur = r.id
            INNER JOIN membre AS mem2
                ON r.membre = mem2.id
        */
        $matchs = $matchRepository->createQueryBuilder('m')
        ->join('m.candidat', 'c')
        ->addSelect('c')
        ->join('c.membre', 'mem1')
        ->addSelect('mem1')
        ->join('m.recruteur', 'r')
        ->addSelect('r')
        ->join('r.membre', 'mem2')
        ->addSelect('mem2')
        ->getQuery()
        ->getResult();

        return $this->render('match/index.html.twig', [
            'matchs' => $matchs,
        ]);
    }
    /*
       Adapter l'URL et le nom de la route selon la table en BDD
       Penser à faire tous les use
   */

    /**
     * @Route("/match/add", name="match_add")
     */
    public function add(Request $request, ObjectManager $objectManager)
    {
        //Adapter les 3 lignes ci-dessous selon la table en BDD
        //Il s'agit de la création du formulaire
        $match = new Match();
        $matchForm = $this->createForm(MatchType::class, $match);
        $matchForm->handleRequest($request);

        //A la soumission du formulaire
        if( $matchForm->isSubmitted() && $matchForm->isValid() ){
            //Pour les champs de type DateTime, utiliser le setter() avec comme argument new \DateTime
            $match->setDateMatch( new \DateTime() );

            //Injection en BDD
            $objectManager->persist($match);
            $objectManager->flush();

            //Redirection vers l'affichage - Mettre en argument le nom de la route
            return $this->redirectToRoute('membre');
        }

        //Rendu du formulaire
        return $this->render('match/add.html.twig', [
            'match_form' => $matchForm->createView(),
        ]);
    }
}

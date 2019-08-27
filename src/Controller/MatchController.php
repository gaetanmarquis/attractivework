<?php

namespace App\Controller;

use App\Entity\Match;
use App\Form\MatchType;
use App\Repository\LikeRepository;
use App\Repository\MatchRepository;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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


    /**
     * @Route("/match/add", name="match_add")
     * @Route("/match/edit/{id}", name="match_edit")
     */
    public function add(Request $request, ObjectManager $objectManager, Match $match = null)
    {
        //Adapter les 3 lignes ci-dessous selon la table en BDD
        //Il s'agit de la création du formulaire
        if( $match === null ){
            $match = new Match();
        }
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
            return $this->redirectToRoute('match');
        }

        //Rendu du formulaire
        return $this->render('match/add.html.twig', [
            'match_form' => $matchForm->createView(),
        ]);
    }

    /**
     * @Route("/match/delete/{id}", name="match_delete")
     */
    public function delete(Match $match, ObjectManager $objectManager)
    {
        if( $match !== null ){
            $objectManager->remove($match);
            $objectManager->flush();
        }
        return $this->redirectToRoute('match');
    }


    /**
     * @Route("/match/result/{id}", name="match_result")
     */
    public function match(
        ObjectManager $objectManager,
        CandidatRepository $candidatRepository, 
        RecruteurRepository $recruteurRepository, 
        LikeRepository $likeRepository, 
        int $id)
    { 
        $membre = $this->getUser();

        if( $membre->getRoleEmploi() === 'candidat' ){
            $candidat = $candidatRepository->createQueryBuilder('c')
                ->join('c.membre', 'm')
                ->addSelect('m')
                ->where('c.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $recruteur = $recruteurRepository->find($id);
        }
        elseif( $membre->getRoleEmploi() === 'recruteur' ){
            $recruteur = $recruteurRepository->createQueryBuilder('r')
                ->join('r.membre', 'm')
                ->addSelect('m')
                ->where('r.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $candidat = $candidatRepository->find($id);
        }

        $like = $likeRepository->createQueryBuilder('l')
            ->where('l.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->andwhere('l.recruteur = :recruteur')
            ->setParameter('recruteur', $recruteur)
            ->getQuery()
            ->getResult();

        // dump($like);
        // dump($candidat[0]);
        // dump($recruteur);

        if( count($like) >= 2 ){
            $match = new Match();

            $match->setCandidat( $candidat[0] )
                ->setRecruteur( $recruteur )
                ->setDateMatch( new \DateTime() );

            $objectManager->persist($match);
            $objectManager->flush();
        }

        if( $membre->getRoleEmploi() === 'candidat' ){
            return $this->redirectToRoute('accueil_candidat');
        }
        elseif( $membre->getRoleEmploi() === 'recruteur' ){
            return $this->redirectToRoute('recruteur_front');
        }
        else{
            return $this->redirectToRoute('home');
        }
    }
}

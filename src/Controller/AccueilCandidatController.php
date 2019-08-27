<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Recruteur;
use App\Repository\LikeRepository;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilCandidatController extends AbstractController
{
    public $limite_affichage = 50;
    public $tab_val_interdite = array();

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/accueil/candidat", name="accueil_candidat")
     */
    public function index( 
        CandidatRepository $candidatRepository, 
        RecruteurRepository $recruteurRepository,
        LikeRepository $likeRepository)
    {

        $recruteurs = array();

        // membre connecté
        $membre = $this->getUser();

        // info candidat du membre
        $candidat = $candidatRepository->createQueryBuilder('c')
            ->where('c.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();

        // like du candidat
        $likeCandidat = $likeRepository->createQueryBuilder('l')
            ->where('l.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->getQuery()
            ->getResult();


        // id des recruteurs likés
        for( $l = 0; $l < count($likeCandidat); $l++ ){
            $tabL[] = $likeCandidat[$l]->getRecruteur()->getId();
        }

        // tous les recruteurs
        $recruteursAll = $recruteurRepository->findAll();

        // id de tous ls recruteurs
        for( $r = 0; $r < count($recruteursAll); $r++ ){
            $tabR[] = $recruteursAll[$r]->getId();
        }
        
        // pour chaque recruteur
        for( $iBcl1 = 0; $iBcl1 < count($tabR); $iBcl1++ ){

            // pour chaque recruteurs likés
            for( $iBcl2 = 0; $iBcl2 < count($tabL); $iBcl2++ ){


                if(array_key_exists($iBcl1, $tabR)){

                    // si le recruteur est liké
                    if( $tabR[$iBcl1] === $tabL[$iBcl2] ){
                        // supprimé de la liste de recruteurs à afficher
                        unset($tabR[$iBcl1]);
                        $iBcl1++;
                    }
                }
            }
        }

        // nbr d'affichages
        if( count($tabR) > 50 ){
            $nbr_affichage = 50;
        }
        else{
            $nbr_affichage = count($tabR);
        }

        // pour chaque recruteur à afficher
        for($i = 0; $i < $nbr_affichage; $i++){

            $index = 0;

            // sélection aléatoire
            $index = array_rand($tabR);
            $id = $tabR[$index];
            
            // sélection du recruteur
            //$recruteurs[] = $recruteurRepository->find($id);
            
            $recruteurs[] = $recruteurRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();        
            
            // suppression dans la liste des recruteurs à afficher
            unset($tabR[$index]);
        }


        return $this->render('accueil_candidat/index.html.twig', [
            'recruteurs' => $recruteurs,
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/accueil/candidat/{id}", name="select_recruteur")
     */
    public function selectRecruteur( 
        CandidatRepository $candidatRepository,
        RecruteurRepository $recruteurRepository, 
        Request $request, 
        ObjectManager $objectManager,
        int $id)
    {
        $like = new Like();

        $membre = $this->getUser();

        $candidat = $candidatRepository->createQueryBuilder('c')
            ->where('c.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();

        $recruteur = $recruteurRepository->find($id);

        // dump($candidat);
        // dump($recruteur);

        $like->setCandidat( $candidat[0] )
            ->setRecruteur( $recruteur )
            ->setDateLike( new \DateTime() );

        $objectManager->persist($like);
        $objectManager->flush();

        return $this->redirectToRoute('accueil_candidat');
    }
}

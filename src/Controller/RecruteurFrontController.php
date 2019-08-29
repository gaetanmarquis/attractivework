<?php
namespace App\Controller;
use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class RecruteurFrontController extends AbstractController
{
    public $limite_affichage = 50;
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/accueil/recruteur", name="recruteur_front")
     */
    public function index(
        CandidatRepository $candidatRepository,
        RecruteurRepository $recruteurRepository,
        LikeRepository $likeRepository)
    {
        $candidats = array();
        $tabL = array();
        $tabC = array();
        // membre connecté
        $membre = $this->getUser();
        // info recruteur du membre
        $recruteur = $recruteurRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->where('r.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();
        // dump($recruteur)
        // like du recruteur
        $likeRecruteur = $likeRepository->createQueryBuilder('l')
            ->where('l.recruteur = :recruteur')
            ->setParameter('recruteur', $recruteur)
            ->andWhere('l.role_like = :roleLike')
            ->setParameter('roleLike', $membre->getRoleEmploi())
            ->getQuery()
            ->getResult();
        // id des candidats likés
        for( $l = 0; $l < count($likeRecruteur); $l++ ){
            $tabL[] = $likeRecruteur[$l]->getCandidat()->getId();
        }
        // tous les candidats
        $candidatsAll = $candidatRepository->findAll();
        // id de tous les candidats
        for( $c = 0; $c < count($candidatsAll); $c++ ){
            $tabC[] = $candidatsAll[$c]->getId();
        }
        // pour chaque candidat
        for( $iBcl1 = 0; $iBcl1 < count($tabC); $iBcl1++ ){
            // pour chaque candidat likés
            for( $iBcl2 = 0; $iBcl2 < count($tabL); $iBcl2++ ){
                if(array_key_exists($iBcl1, $tabC)){
                    // si le candidat est liké
                    if( $tabC[$iBcl1] === $tabL[$iBcl2] ){
                        // supprimer de la liste des candidats à afficher
                        unset($tabC[$iBcl1]);
                        $iBcl1++;
                    }
                }
            }
        }

        // nbr d'affichages
        if( count($tabC) > $this->limite_affichage ){
            $nbr_affichage = $this->limite_affichage;
        }
        else{
            $nbr_affichage = count($tabC);
        }
        // pour chaque candidat à afficher
        for($i = 0; $i < $nbr_affichage; $i++ ){
            $index = 0;
            // sélection aléatoire
            $index = array_rand($tabC);
            $id = $tabC[$index];
            // sélection des candidats
            $candidats[] = $candidatRepository->createQueryBuilder('c')
                ->join('c.membre', 'm')
                ->addSelect('m')
                ->where('c.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult();
            // suppression dans la liste des candidats à afficher
            unset($tabC[$index]);

        }
        return $this->render('accueil_recruteur/index.html.twig', [
            'candidats' => $candidats,
        ]);
    }
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/recruteur/profil/{id}", name="select_candidat")
     */
    public function selectCandidat(
        CandidatRepository $candidatRepository,
        RecruteurRepository $recruteurRepository,
        ObjectManager $objectManager,
        int $id)
    {
        $like = new Like();
        $membre = $this->getUser();
        $recruteur = $recruteurRepository->createQueryBuilder('r')
            ->where('r.membre = :membre')
            ->setParameter('membre', $membre)
            ->getQuery()
            ->getResult();
        $candidat = $candidatRepository->find($id);
        // dump($candidat);
        // dump($recruteur);
        $like->setCandidat( $candidat )
            ->setRecruteur( $recruteur[0] )
            ->setRoleLike( $membre->getRoleEmploi() )
            ->setDateLike( new \DateTime() );
        $objectManager->persist($like);
        $objectManager->flush();

        return $this->redirectToRoute('match_result', [ 'id' => $id ]);
    }
}

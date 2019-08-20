<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="offre")
     */
    public function index(OffreRepository $offreRepository)
    {
        /**  SELECT * FROM offre
         * $recruteurs = $recruteurRepository->findAll()
         */

        /**
         * SELECT * FROM offre AS o
         * INNER JOIN id AS r
         * ON r.id = r.id
         */
        $offres = $offreRepository->createQueryBuilder('o')
            ->join('o.recruteur', 'r')
            ->addSelect('r')
            ->getQuery()
            ->getResult();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("/offre/add", name="offre_add")
     * @Assert\DateTime
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @var string A "d-m-Y H:i:s" formatted value
     */
    public function add(Request $request, ObjectManager $objectManager)
    {
        //Adapter les 3 lignes ci-dessous selon la table en BDD
        //Il s'agit de la création du formulaire
        $offre = new offre();
        $offreForm = $this->createForm(offreType::class, $offre);
        $offreForm->handleRequest($request);

        //A la soumission du formulaire
        if( $offreForm->isSubmitted() && $offreForm->isValid() ){
            //Pour les champs de type DateTime, utiliser le setter() avec comme argument new \DateTime
            $offre->setter( new \DateTime() );

            //Injection en BDD
            $objectManager->persist($offre);
            $objectManager->flush();

            //Redirection vers l'affichage - Mettre en argument le nom de la route
            return $this->redirectToRoute('offre');
        }

        //Rendu du formulaire
        return $this->render('offre/add.html.twig', [
            'offre_form' => $offreForm->createView(),
        ]);
    }

}

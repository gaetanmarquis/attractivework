<?php

namespace App\Controller;

use App\Entity\Personnalite;
use App\Form\PersonnaliteType;
use App\Repository\PersonnaliteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonnaliteController extends AbstractController
{
    /**
     * @Route("/personnalite", name="personnalite")
     */
    public function index ( PersonnaliteRepository $personnaliteRepository)
    {
        $personnalites = $personnaliteRepository->findAll();
        return $this->render('personnalite/index.html.twig', [
            'personnalites' => $personnalites,
        ]);
    }

    /**
     * @Route("/personnalite/add", name="personnalite_add")
     */
    public function add(Request $request, ObjectManager $objectManager)
    {
        //Adapter les 3 lignes ci-dessous selon la table en BDD
        //Il s'agit de la création du formulaire
        $personnalite = new Personnalite();
        $personnaliteForm = $this->createForm(PersonnaliteType::class, $personnalite);
        $personnaliteForm->handleRequest($request);

        //A la soumission du formulaire
        if( $personnaliteForm->isSubmitted() && $personnaliteForm->isValid() ){
            //Injection en BDD
            $objectManager->persist($personnalite);
            $objectManager->flush();

            //Redirection vers l'affichage - Mettre en argument le nom de la route
            return $this->redirectToRoute('personnalite');
        }

        //Rendu du formulaire
        return $this->render('personnalite/add.html.twig', [
            'personnalite_form' => $personnaliteForm->createView(),
        ]);
    }
}

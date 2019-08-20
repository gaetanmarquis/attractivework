<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Form\RecruteurType;
use App\Repository\RecruteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruteurController extends AbstractController
{
    /**
     * @Route("/recruteur", name="recruteur")
     */
    public function index(RecruteurRepository $recruteurRepository)
    {
        $recruteurs = $recruteurRepository->createQueryBuilder('r')
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();
        
        return $this->render('recruteur/index.html.twig', [
            'recruteurs' => $recruteurs,
        ]);
    }

    /**
     * @Route("/recruteur/add", name="recruteur_add")
     */
    public function add(Request $request, ObjectManager $objectManager)
    {
        $recruteur = new Recruteur();
        $recruteurForm = $this->createForm(RecruteurType::class, $recruteur);
        $recruteurForm->handleRequest($request);

        return $this->render('recruteur/add.html.twig', [
            'recruteur_form' => $recruteurForm->createView(),
        ]);
    }
}

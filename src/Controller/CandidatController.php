<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat", name="candidat")
     */
    public function index(CandidatRepository $candidatRepository)
    {
        $candidats = $candidatRepository->createQueryBuilder('c')
            ->join('c.membre', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();
            
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidats,
        ]);
    }

    /**
     * @Route("/candidat/add", name="candidat_add")
     */
    public function add(Request $request, ObjectManager $objectManager)
    {
        $candidat = new Candidat();
        $candidatForm = $this->createForm(CandidatType::class, $candidat);
        $candidatForm->handleRequest($request);

        return $this->render('candidat/add.html.twig', [
            'candidat_form' => $candidatForm->createView(),
        ]);
    }
}

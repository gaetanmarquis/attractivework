<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\MembreRepository;
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
     * @Route("/candidat/edit/{id}", name="candidat_edit")
     */
    public function add(Request $request, ObjectManager $objectManager, MembreRepository $membreRepository, Candidat $candidat = null)
    {
        // dump($candidat);
        
        if ($candidat === null) {
            $candidat = new Candidat();
            $id_membre = $_GET['id_membre'];
            $membre = $membreRepository->find($id_membre);
        }

        $candidatForm = $this->createForm(CandidatType::class, $candidat);
        $candidatForm->handleRequest($request);


        if ($candidatForm->isSubmitted() && $candidatForm->isValid()) {
            if ($candidat === null) {
                $candidat->setMembre($membre);
            }

            $objectManager->persist($candidat);
            $objectManager->flush();

            return $this->redirectToRoute('candidat');
        }

        return $this->render('candidat/add.html.twig', [
            'candidat_form' => $candidatForm->createView(),
        ]);
        
    }

    /**
     *@Route("/candidat/delete/{id}", name="candidat_delete")
     */
    public function delete(Candidat $candidat, ObjectManager $objectManager){

        if( $candidat !== null ){
            $objectManager->remove($candidat);
            $objectManager->flush();
        }
        return $this->redirectToRoute('candidat');

    }
}

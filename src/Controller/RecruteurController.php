<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Form\RecruteurType;
use App\Repository\MembreRepository;
use App\Repository\RecruteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @Route("/recruteur/edit/{id}", name="recruteur_edit")
     */
    public function add(Request $request, ObjectManager $objectManager, MembreRepository $membreRepository, Recruteur $recruteur = null)
    {
            if($recruteur === null){
                $recruteur = new Recruteur();
                $id_membre = $_GET['id_membre'];
                $membre = $membreRepository->find($id_membre);
            }

        $recruteurForm = $this->createForm(RecruteurType::class, $recruteur);
        $recruteurForm->handleRequest($request);

        if( $recruteurForm->isSubmitted() && $recruteurForm->isValid() ){
            $recruteur->setMembre( $membre );
            $recruteur->setDescriptionLogo( 'Logo de ' . $recruteur->getNomEntreprise() );

            /**@var UploadedFile $imageFile */
            if( $recruteur->getImageFile() !== null ){

                $imageFile = $recruteur->getImageFile();
                $folder = 'upload';
                $filename = uniqid();
                $imageFile->move( $folder, $filename );
                $recruteur->setLogoEntreprise( $folder . DIRECTORY_SEPARATOR . $filename );
            }

            //Injection en BDD
            $objectManager->persist($recruteur);
            $objectManager->flush();

            return $this->redirectToRoute('recruteur');
        }

        return $this->render('recruteur/add.html.twig', [
            'recruteur_form' => $recruteurForm->createView(),
        ]);
    }

    /**
     * @Route("/recruteur/delete/{id}", name="delete_recruteur")
     */
    public function delete(ObjectManager $objectManager, Recruteur $recruteur)
    {
        if ($recruteur !== null) {
            $objectManager->remove($recruteur);
            $objectManager->flush();
        }

        return $this->redirectToRoute('recruteur');
    }
}

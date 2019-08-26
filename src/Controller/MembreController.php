<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembreController extends AbstractController
{
    /**
     * URL et nom de la route
     * @Route("/membre", name="membre")
     */
    public function index(MembreRepository $membreRepository)
    {
        /* 
            SELECT * FROM membre
            $membres = $membreRepository->findAll()
        */

        /*
            SELECT * FROM membre AS m
            INNER JOIN personnalite AS p
                ON m.personnalite = p.id
        */
        $membres = $membreRepository->createQueryBuilder('m')
        ->join('m.personnalite', 'p')
        ->addSelect('p')
        ->getQuery()
        ->getResult();

        // Affichage des membres
        return $this->render('membre/index.html.twig', [
            'membres' => $membres,
        ]);
    }

    /**
     * @Route("/membre/add", name="membre_add")
     * @Route("/membre/edit/{id}", name="membre_edit")
     */
    public function add(Request $request, ObjectManager $objectManager, Membre $membre = null)
    {
        $valueBtn = 'modifier';

        if( $membre === null) {
            $membre = new Membre();
            $valueBtn = 'ajouter';
        }
        
        $membreForm = $this->createForm(MembreType::class, $membre);
        $membreForm->handleRequest($request);

        if( $membreForm->isSubmitted() && $membreForm->isValid() ){
            
            $membre->setDateInscription( new \DateTime() );
            $membre->setStatut( 'ROLE_USER' );
            $membre->setDescriptionPhoto( 'Photo de profil de ' . $membre->getNom() . ' ' . $membre->getPrenom() );

            /**@var UploadedFile $imageFile */
            if( $membre->getImageFile() !== null ){

                $imageFile = $membre->getImageFile();
                $folder = 'upload';
                $filename = uniqid();
                $imageFile->move( $folder, $filename );
                $membre->setPhotoProfil( $folder . DIRECTORY_SEPARATOR . $filename );
            }

            $objectManager->persist($membre);
            $objectManager->flush();

            if( $valueBtn === 'ajouter' ){
                if( $_POST['role'] === 'candidat' ){
                    //formulaire candidat
                    return $this->redirectToRoute('candidat_add', ['id_membre' => $membre->getId()]);
                }
                elseif( $_POST['role'] === 'recruteur' ){
                    //formulaire recruteur
                    return $this->redirectToRoute('recruteur_add', ['id_membre' => $membre->getId()]);
                }
            }
            else{
                return $this->redirectToRoute('membre');
            }
        }

        return $this->render('membre/add.html.twig', [
            'membre_form' => $membreForm->createView(),
            'value_btn' => $valueBtn,
        ]);
    }

    /**
    * @Route("/membre/delete/{id}", name="membre_delete")
    */
    public function delete(Membre $membre, ObjectManager $objectManager){

        if( $membre !== null ){
            $objectManager->remove($membre);
            $objectManager->flush();
        }
        return $this->redirectToRoute('membre');
    }
}

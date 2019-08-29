<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Repository\RecruteurRepository;
use App\Form\RecruteurType;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use App\Form\MembreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilPersoRecruteurController extends AbstractController
{
    /**
     * @Route("/profil/perso/recruteur/{id}", name="profil_perso_recruteur")
     */
    public function index( RecruteurRepository $recruteurRepository, int $id )
    {

    	$recruteur = $recruteurRepository->createQueryBuilder('r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->join('r.membre', 'm')
            ->addSelect('m')
            ->join('m.personnalite', 'p')
            ->addSelect('p')
            ->getQuery()
            ->getResult();

        return $this->render('profil_perso_recruteur/index.html.twig', [
            'recruteur' => $recruteur[0],
        ]);
    }

    /**
     * @Route("/profil/perso/recruteur/{id}/edit/cv", name="profil_perso_cv_edit")
     */
    public function edit_cv(Request $request, ObjectManager $objectManager, Recruteur $recruteur = null)
    {

        $recruteurForm = $this->createForm(RecruteurType::class, $recruteur);
        $recruteurForm->handleRequest($request);

        if( $recruteurForm->isSubmitted() && $recruteurForm->isValid() ){
            $recruteur->setMembre( $this->getUser() );

            $objectManager->persist($recruteur);
            $objectManager->flush();

            return $this->render('profil_perso_recruteur/index.html.twig', [
            'recruteur' => $recruteur[0],
        ]);
        }

        return $this->render('recruteur/add.html.twig', [
            'recruteur_form' => $recruteurForm->createView(),
        ]);
    }

    /**
     * @Route("/profil/perso/recruteur/{id}/edit/infos", name="profil_perso_infos_edit")
     */
    public function edit_infos(Request $request, ObjectManager $objectManager, RecruteurRepository $recruteurRepository, int $id)
    {

    	$recruteur = $recruteurRepository->createQueryBuilder('r')
    	->where('r.id = :id')
    	->setParameter('id', $id)
    	->join('r.membre', 'm')
    	->addSelect('m')
    	->getQuery()
    	->getResult();

    	$membre = $recruteur[0]->getMembre();

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

            if( $_POST['role'] === 'candidat' ){
                //formulaire candidat
                return $this->redirectToRoute('candidat_add', ['id_membre' => $membre->getId()]);
            }
            elseif( $_POST['role'] === 'recruteur' ){
                //formulaire recruteur
                return $this->redirectToRoute('recruteur_add', ['id_membre' => $membre->getId()]);
            }
        }

        return $this->render('membre/add.html.twig', [
            'membre_form' => $membreForm->createView(),
            'value_btn' => 'modifier',
        ]);
    }
}

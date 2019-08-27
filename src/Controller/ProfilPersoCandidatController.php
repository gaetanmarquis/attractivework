<?php

namespace App\Controller;


use App\Entity\Candidat;
use App\Repository\CandidatRepository;
use App\Form\CandidatType;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use App\Form\MembreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProfilPersoCandidatController extends AbstractController
{
    /**
     * @Route("/profil/perso/candidat/{id}", name="profil_perso_candidat")
     */
    public function index( CandidatRepository $candidatRepository, int $id )
    {

    	$candidat = $candidatRepository->createQueryBuilder('c')
    	->where('c.id = :id')
    	->setParameter('id', $id)
    	->join('c.membre', 'm')
    	->addSelect('m')
        ->join('m.personnalite', 'p')
        ->addSelect('p')
    	->getQuery()
    	->getResult();

    	// dump($candidat);

        return $this->render('profil_perso_candidat/index.html.twig', [
            'candidat' => $candidat[0],
        ]);
    }


    /**
     * @Route("/profil/perso/candidat/{id}/edit/cv", name="profil_perso_cv_edit")
     */
    public function edit_cv(Request $request, ObjectManager $objectManager, Candidat $candidat = null)
    {

        $candidatForm = $this->createForm(CandidatType::class, $candidat);
        $candidatForm->handleRequest($request);

        if( $candidatForm->isSubmitted() && $candidatForm->isValid() ){
            $candidat->setMembre( $this->getUser() );

            $objectManager->persist($candidat);
            $objectManager->flush();

            return $this->render('profil_perso_candidat/index.html.twig', [
            'candidat' => $candidat[0],
        ]);
        }

        return $this->render('candidat/add.html.twig', [
            'candidat_form' => $candidatForm->createView(),
        ]);
    }

    /**
     * @Route("/profil/perso/candidat/{id}/edit/infos", name="profil_perso_infos_edit")
     */
    public function edit_infos(Request $request, ObjectManager $objectManager, Membre $membre = null)
    {

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

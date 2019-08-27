<?php

namespace App\Controller;

use App\Entity\Personnalite;
use App\Repository\PersonnaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonnaliteDetailsController extends AbstractController
{
    /**
     * @Route("/personnalite/details/{id}/{role}", name="personnalite_details")
     */
    public function index( PersonnaliteRepository $personnaliteRepository, int $id, string $role)
    {

    	$personnalite = $personnaliteRepository->find($id);

        return $this->render('personnalite_details/index.html.twig', [
            'personnalite' => $personnalite,
            'role' => $role,
        ]);
    }
}

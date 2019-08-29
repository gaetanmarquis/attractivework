<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutocompleteController extends AbstractController
{
    /**
     * @Route("/search/candidat", name="search_candidat")
     */
    public function searchCandidat(Request $request, MembreRepository $membreRepository): Response
    {
        $q = $request->query->get('term'); // use "term" instead of "q" for jquery-ui
        $results = $membreRepository->createQueryBuilder('m')
            ->where('m.nom LIKE :nom')
            ->orWhere('m.prenom LIKE :prenom')
            ->setParameter('nom', "$q%")
            ->setParameter('prenom', "$q%")
            ->getQuery()
            ->getResult();

        return $this->render('autocomplete/search_candidat.json.twig', ['results' => $results]);
    }

    /**
     * @Route("/get/candidat", name="get_candidat")
     */
    public function getCandidat(MembreRepository $membreRepository, $id = null): Response
    {
        $membre = $membreRepository->find($id);

        return $this->json($membre->getPrenom() . ' '. $membre->getNom());
    }

    /* =================================== search recruteur ==========================================================*/

    /**
     * @Route("/search/recruteur", name="search_recruteur")
     */
    public function searchRecruteur(Request $request, MembreRepository $membreRepository): Response
    {
        $q = $request->query->get('term'); // use "term" instead of "q" for jquery-ui
        $results = $membreRepository->createQueryBuilder('m')
            ->where('m.nom LIKE :nom')
            ->orWhere('m.prenom LIKE :prenom')
            ->setParameter('nom', "$q%")
            ->setParameter('prenom', "$q%")
            ->getQuery()
            ->getResult();

        return $this->render('autocomplete/search_recruteur.json.twig', ['results' => $results]);
    }

    /**
     * @Route("/get/recruteur", name="get_recruteur")
     */
    public function getRecruteur(MembreRepository $membreRepository, $id = null): Response
    {
        $membre = $membreRepository->find($id);

        return $this->json($membre->getPrenom() . ' '. $membre->getNom());
    }
}

<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    /**
     * URL + nom de la route
     * @Route("/message", name="message")
     */
    public function index( MessageRepository $messageRepository )
    {
        /*
            SELECT * FROM message
            $messages = $messageRepository->findAll();
        */

        /*
            SELECT * FROM message AS mes
            INNER JOIN candidat AS c
                ON mes.candidat = c.id
            INNER JOIN membre AS mem1
                ON c.membre = mem1.id
            INNER JOIN recruteur AS r
                ON mes.recruteur = r.id
            INNER JOIN membre AS mem2
                ON r.membre = mem2.id
        */
        $messages = $messageRepository->createQueryBuilder('mes')
        ->join('mes.candidat', 'c')
        ->addSelect('c')
        ->join('c.membre', 'mem1')
        ->addSelect('mem1')
        ->join('mes.recruteur', 'r')
        ->addSelect('r')
        ->join('r.membre', 'mem2')
        ->addSelect('mem2')
        ->getQuery()
        ->getResult();

        // Affichage des messages
        return $this->render('message/index.html.twig', [
            'messages' => $messages,
        ]);
    }
}

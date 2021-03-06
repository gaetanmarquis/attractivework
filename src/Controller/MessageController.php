<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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

    /**
     * @Route("/message/add", name="message_add")
     * @Route("/message/edit/{id}", name="message_edit")
     */
    public function add(Request $request, ObjectManager $objectManager, Message $message = null)
    {
        //Adapter les 3 lignes ci-dessous selon la table en BDD
        //Il s'agit de la création du formulaire

        if ($message === null) {
            $message = new Message();
        }

        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        //A la soumission du formulaire
        if( $messageForm->isSubmitted() && $messageForm->isValid() ){
            //Pour les champs de type DateTime, utiliser le setter() avec comme argument new \DateTime
            $message->setDateMessage( new \DateTime() );

            //Injection en BDD
            $objectManager->persist($message);
            $objectManager->flush();

            //Redirection vers l'affichage - Mettre en argument le nom de la route
            return $this->redirectToRoute('message');
        }

        //Rendu du formulaire
        return $this->render('message/add.html.twig', [
            'message_form' => $messageForm->createView(),
        ]);
    }

    /**
    * @Route("/message/delete/{id}", name="message_delete")
    */
    public function delete(Message $message, ObjectManager $objectManager){

        if( $message !== null ){
            $objectManager->remove($message);
            $objectManager->flush();
        }

        return $this->redirectToRoute('message');


    }
}

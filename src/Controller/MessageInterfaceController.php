<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageInterfaceController extends AbstractController
{

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/message/interface/{id}", name="message_interface")
     */
    public function index( 
        CandidatRepository $candidatRepository, 
        RecruteurRepository $recruteurRepository,
        int $id)
    {
        $membre = $this->getUser();

        if( $membre->getRoleEmploi() === 'candidat' ){
            $candidat = $candidatRepository->createQueryBuilder('c')
                ->join('c.membre', 'm')
                ->addSelect('m')
                ->where('c.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $recruteur[0] = $recruteurRepository->find($id);
        }
        elseif( $membre->getRoleEmploi() === 'recruteur' ){
            $recruteur = $recruteurRepository->createQueryBuilder('r')
                ->join('r.membre', 'm')
                ->addSelect('m')
                ->where('r.membre = :membre')
                ->setParameter('membre', $membre)
                ->getQuery()
                ->getResult();

            $candidat[0] = $candidatRepository->find($id);
        }

        
        return $this->render('message_interface/index.html.twig', [
            'id' => $id,
            'membre' => $membre,
            'candidat' => $candidat[0],
            'recruteur' => $recruteur[0],
        ]);
        
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("ajax_message", name="ajax_message")
     */
    public function ajaxMessage( 
        MessageRepository $messageRepository,
        CandidatRepository $candidatRepository, 
        RecruteurRepository $recruteurRepository,
        ObjectManager $objectManager)
    {
        $membre = $this->getUser();

        $recruteur = $recruteurRepository->find( intval($_POST['recruteur']) );
        $candidat = $candidatRepository->find( intval($_POST['candidat']) );


        if( $_POST['message'] !== "" ){
            $message = new Message();

            $message->setCandidat( $candidat )
                ->setRecruteur( $recruteur )
                ->setAuteur( $membre->getRoleEmploi() )
                ->setMessage( $_POST['message'] )
                ->setDateMessage( new \DateTime() );

            $objectManager->persist( $message );
            $objectManager->flush();
        }

        
        $messages = $messageRepository->createQueryBuilder('m')
            ->where('m.candidat = :candidat')
            ->setParameter('candidat', $candidat)
            ->andWhere('m.recruteur = :recruteur')
            ->setParameter('recruteur', $recruteur)
            
            ->orderBy('m.date_message', 'ASC')

            ->join('m.candidat', 'c')
            ->addSelect('c')
            ->join('c.membre', 'mem1')
            ->addSelect('mem1')
            ->join('m.recruteur', 'r')
            ->addSelect('r')
            ->join('r.membre', 'mem2')
            ->addSelect('mem2')
            
            ->getQuery()
            ->getResult();
        
        
        /*
        $messages = $messageRepository->findAll();
        */
        

        $messages = array_map( function(Message $message){
            return [
                'nomCandidat' => $message->getCandidat()->getMembre()->getNom(),
                'prenomCandidat' => $message->getCandidat()->getMembre()->getPrenom(),
                'nomRecruteur' => $message->getRecruteur()->getMembre()->getNom(),
                'prenomRecruteur' => $message->getRecruteur()->getMembre()->getPrenom(),
                'date' => $message->getDateMessage(),
                'message' => $message->getMessage(),
                'auteur' => $message->getAuteur(),
            ];
        }, $messages );

        
        return $this->json( $messages );
        
    }
}

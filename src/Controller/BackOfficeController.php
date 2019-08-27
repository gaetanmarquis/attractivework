<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BackOfficeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="backoffice")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackOfficeController',
        ]);
    }
}

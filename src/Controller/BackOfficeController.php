<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BackOfficeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="backoffice")
     */
    public function index()
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackOfficeController',
        ]);
    }
}

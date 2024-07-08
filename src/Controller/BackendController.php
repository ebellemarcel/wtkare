<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BackendController extends AbstractController
{
   
    public function admin_dashboard(): Response
    {
        return $this->render('backend/index.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }

    public function admin_liste_proprietes(): Response
    {
     
    }

    public function admin_liste_contacts(): Response
    {
   
    }

    public function admin_propriete_form(): Response
    {

    }

}

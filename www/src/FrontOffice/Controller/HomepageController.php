<?php

namespace FrontOffice\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(Request $req): Response
    {
        $purchase = $req->get('purchase');
        
        //TODO : create a flash message showing the just finished purchase, inspiration : 'front_office/shopping/welcome.html.twig'
        return $this->render(
           'front_office/homepage.html.twig',
           [
              'purchase' => $purchase,
           ]
        );
    }
    
    public function navWalker()
    {
    
    }
}

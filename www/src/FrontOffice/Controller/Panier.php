<?php


namespace FrontOffice\Controller;
use Symfony\Component\Routing\Annotation\Route;


class Panier extends AbstractController
{
    /**
     * @Route("/panier", name="fo_panier_index")
     */
    public function index()
    {
        return $this->render('front_office/panier.html.twig');
    }
}


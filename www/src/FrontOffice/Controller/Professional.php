<?php


namespace FrontOffice\Controller;
use Symfony\Component\Routing\Annotation\Route;


class Professional extends AbstractController
{
    /**
     * @Route("/pro", name="fo_pro_index")
     */
    public function index()
    {
        return $this->render('front_office/professional.html.twig');
    }
}


<?php

namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ZeroDechetController extends AbstractController
{
    /**
     * @Route("/zerodechet", name="fo_dechet")
     */
    public function zerodechet()
    {
        return $this->render('front_office/zerodechet.html.twig');
    }
}

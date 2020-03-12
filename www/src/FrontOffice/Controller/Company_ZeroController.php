<?php

namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class Company_ZeroController extends AbstractController
{
    /**
     * @Route("/company", name="company")
     */
    public function companyTemp()
    {
        return $this->render('front_office/company.html.twig');
    }

    /**
     * @Route("/zerodechet", name="zerodechet")
     */
    public function zero()
    {
        return $this->render('front_office/zerodechet.html.twig');
    }
}


<?php

namespace FrontOffice\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("/mentionslegales", name="mentions")
     */
    public function mentions()
    {
        return $this->render(
           'front_office/legalPage/mentions.html.twig'
        );
    }

    /**
     * @Route("/rgpd", name="rgpd")
     */
    public function rgpd()
    {
        return $this->render(
            'front_office/legalPage/data.html.twig'
        );
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render(
            'front_office/legalPage/contact.html.twig'
        );
    }
}

<?php


namespace FrontOffice\Controller;
use Symfony\Component\Routing\Annotation\Route;


class ProController extends AbstractController
{
    /**
     * @Route("/services-pro", name="proServiceList")
     */
    public function index()
    {
        return $this->render('front_office/proServiceList.html.twig');
    }
}


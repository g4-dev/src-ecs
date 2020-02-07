<?php


namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class DiyController extends AbstractController
{
    /**
     * @Route("/diy", name="diyList")
     */
    public function index()
    {
        return $this->render('front_office/cms/diyList.html.twig');
    }
    /**
     * @Route("/diy/1", name="diyShow")
     */
    public function show()
    {
        return $this->render('front_office/cms/diyShow.html.twig');
    }
}

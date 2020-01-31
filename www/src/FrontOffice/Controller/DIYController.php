<?php


namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class DIYController extends AbstractController
{
    /**
     * @Route("/diy", name="fo_diy_index")
     */
    public function index()
    {
        return $this->render('front_office/diy/index.html.twig');
    }
    /**
     * @Route("/diy/1", name="fo_diy_show")
     */
    public function show()
    {
        return $this->render('front_office/diy/show.html.twig');
    }
}

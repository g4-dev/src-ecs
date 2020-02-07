<?php

namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    // TODO : Take this his example to build a well organized page
    /**
     * @Route("/template-manual", name="company")
     */
    public function company()
    {
        $content = "never do a thing like that (be generic)";
        return $this->render('front_office/cms/cmsShow.html.twig',
           [
              "content" => $content,
               "layout" => 'two-cols'
           ]);
    }
}

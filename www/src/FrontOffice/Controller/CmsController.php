<?php

namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class CmsController extends AbstractController
{
    /**
     * @Route("/cms/{slug}", name="cmsShow", requirements={"slug"="^[A-Za-z0-9-]*$"})
     */
    public function showAction($slug)
    {
        // TODO: show an article identified by his slug and inject correct data in the template
        return $this->render('front_office/cms/cmsPagesShow.html.twig');
    }
    
    /**
     * @Route("/cms", name="cmsList", requirements={"slug"="^[A-Za-z0-9-]*$"})
     */
    public function showList()
    {
        return $this->render('front_office/cms/cmsPagesList.html.twig');
    }
}

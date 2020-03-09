<?php

namespace FrontOffice\Controller;

use Admin\Entity\CmsCategory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/category/cms/{page}", name="cmsPagesList")
     */
    public function listCmsPagesAction($page,  Request $req)
    {
        // TODO: prendre le code de easyadmin pour faire la pagination
        // Pagination de tout
        // En ajax si possible
        $qb = $this->getDoctrine()
            ->getRepository(CmsCategory::class)
            ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/cms/cmsPagesList.html.twig', [
            'products' => $pagerfanta
        ]);
    }
}

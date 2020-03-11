<?php

namespace FrontOffice\Controller;

use Admin\Entity\CmsCategory;
use Admin\Entity\CmsPage;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CmsController extends AbstractController
{
    /**
     * @Route("/cms/{slug}",
     *     name="cmsShow",
     *     requirements={"slug"="^[A-Za-z0-9-]*$"}
     * )
     */
    public function cmsShow(string $slug)
    {
        $cmsPage = $this->getDoctrine()
           ->getRepository(CmsPage::class)
           ->findOneBySlug($slug);
        
        // TODO: show an article identified by his slug and inject correct data in the template
        return $this->render('front_office/cms/cmsPageShow.html.twig', [
           'cmsPage' => $cmsPage,
            'layout' => $cmsPage->getLayout()
        ]);
    }
    
    /**
     * @Route("/cms/category/{slug}/{page?1}",
     *     name="cmsCategoryList",
     *     requirements={"slug"="^[A-Za-z0-9-]*$"},
     *     requirements={"page"="\d+"}
     * )
     */
    public function cmsCategoryList(Request $req, string $slug, ?int $page = 1)
    {
        // TODO: prendre le code de easyadmin pour faire la pagination
        // Pagination de tout
        // En ajax si possible
        $category = $this->getDoctrine()
            ->getRepository(CmsCategory::class)
            ->findOneBySlug($slug);
        
        $cmsPages = $category->getItems();
        
        $adapter = new DoctrineCollectionAdapter($cmsPages);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
    
        dump($pagerfanta);
        
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/cms/cmsPagesList.html.twig', [
            'cmsPages' => $pagerfanta,
            'category' => $category,
            'categorySlug' => $slug
        ]);
    }
}

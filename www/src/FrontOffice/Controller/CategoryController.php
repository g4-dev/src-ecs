<?php


namespace FrontOffice\Controller;

use Admin\Entity\CmsCategory;
use Admin\Entity\ProductCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/products/{page}", name="productCategoryList")
     */
    public function listProductsAction($page,  Request $req)
    {
        // TODO: prendre le code de easyadmin pour faire la pagination
        // Pagination de tout
        // En ajax si possible
        $qb = $this->getDoctrine()
           ->getRepository(ProductCategory::class)
           ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/shopping/productList.html.twig', [
           'products' => $pagerfanta
        ]);
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

<?php


namespace FrontOffice\Controller;

use Admin\Entity\AbstractCategory;
use Admin\Entity\Product;
use Admin\Entity\ProductCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/{slug}/{page?1}", name="productList")
     */
    public function listAction(Request $req, string $slug, ?int $page = 1)
    {
        // TODO: prendre le code de easyadmin pour faire la pagination
        // Pagination de tout
        // En ajax si possible
        $qb = $this->getDoctrine()
           ->getRepository(Product::class)
           ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        
        dump($pagerfanta);
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/shopping/productAll.html.twig', [
           'products' => $pagerfanta,
            'slug' => $slug
        ]);
    }
    
    /**
     * @Route("/product/{slug}", name="productShow", requirements={"slug"="^[A-Za-z0-9-]*$"})
     * @param $slug
     * @return Response
     */
    public function showAction(string $slug)
    {
        $product = $this->getDoctrine()
           ->getRepository(Product::class)
           ->findOneBySlug($slug);
        
        if (!$product) {
            throw $this->createNotFoundException();
        }
        // TODO: afficher le produit dans les vues twig
        return $this->render('front_office/shopping/productShow.html.twig', [
           'product' => $product,
        ]);
    }

    /**
     * @Route("/category/products/{slug}/{page?1}", name="productCategoryList", requirements={"slug"="^[A-Za-z0-9-]*$"})
     */
    public function listProductsByCategoryAction(string $slug,  Request $req, ?int $page = 1)
    {
        // Pagination de tout
        $qb = $this->getDoctrine()
            ->getRepository(ProductCategory::class)
            ->findOneBySlug()
            ->findAllQueryBuilder();
        dump($qb);
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/shopping/productList.html.twig', [
            'products' => $pagerfanta,
            'slug' => $slug
        ]);
    }
}

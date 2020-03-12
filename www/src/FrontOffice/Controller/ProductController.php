<?php


namespace FrontOffice\Controller;

use Admin\Entity\Product;
use Admin\Entity\ProductCategory;
use FrontOffice\Controller\Shopping\BasketController;
use FrontOffice\Form\Shopping\AddToBasketType;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/{page?1}", name="productList")
     */
    public function productList(Request $req, ?int $page = 1)
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
        
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/shopping/productAll.html.twig', [
           'products' => $pagerfanta,
        ]);
    }
    
    /**
     * @Route("/product/{slug}", name="productShow", requirements={"slug"="^[A-Za-z0-9-]*$"})
     * @param $slug
     * @return Response
     */
    public function productShow(Request $request, string $slug)
    {
        $comeFromCategory = $request->request->get('comeFromCategory') ?? null;
        $productRepo = $this->getDoctrine()
           ->getRepository(Product::class);
        
        $product = $productRepo->findOneBySlug($slug);
        $lastProducts = $productRepo->findLatest(4);
        
        if (!$product) {
            throw $this->createNotFoundException();
        }
    
        $form = $this->createForm(AddToBasketType::class, [
           'product_id' => $product->getId()
        ]);
        
        $form->handleRequest($request);
        
        // TODO: afficher le produit dans les vues twig
        return $this->render('front_office/shopping/productShow.html.twig', [
           'product' => $product,
           'lastProducts' => $lastProducts,
           'form' => $form->createView(),
           'comeFromCategory' => $comeFromCategory
        ]);
    }

    /**
     * @Route("/category/products/{slug}/{page?1}", name="productCategoryList", requirements={"slug"="^[A-Za-z0-9-]*$"})
     */
    public function productCategoryList(Request $req, string $slug,  ?int $page = 1)
    {
        // Pagination de tout
        $category = $this->getDoctrine()
            ->getRepository(ProductCategory::class)
            ->findOneBySlug($slug);
        
        $products = $category->getItems();
    
        $adapter = new DoctrineCollectionAdapter($products);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        
        //vue temporaire en attendant pour tester l'ajout au panier
        return $this->render('@fo/shopping/productList.html.twig', [
            'products' => $pagerfanta,
            'category' => $category,
            'slug' => $slug
        ]);
    }
}

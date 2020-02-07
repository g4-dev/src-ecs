<?php


namespace FrontOffice\Controller;

use Admin\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/{page}", name="productList")
     */
    public function allAction($page, Request $req)
    {
        // TODO: prendre le code de easyadmin pour faire la pagination
        // Pagination de tout
        // En ajax si possible
        
        return $this->render('@fo/shopping/productList.html.twig');
    }
    
    /**
     * @Route("/product/{slug}", name="productShow", requirements={"slug"="^[A-Za-z0-9-]*$"})
     * @param $slug
     * @return Response
     */
    public function showAction(string $slug)
    {
        dump($slug);
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
}

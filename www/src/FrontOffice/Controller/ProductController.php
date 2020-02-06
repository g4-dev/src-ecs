<?php


namespace FrontOffice\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/category", name="fo_product_index")
     */
    public function index()
    {
        return $this->render('front_office/product_category.html.twig');
    }
    /**
     * @Route("/product/1", name="fo_product_show")
     */
    public function show()
    {
        return $this->render('front_office/product.html.twig');
    }
}

<?php


namespace FrontOffice\Controller;

use Admin\Entity\Product;
use FrontOffice\Form\ProductTypeForm;
use Core\Service\Slugger;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/all-products/{page}", name="fo_product_index")
     */
    public function index()
    {
        $form = $this->createFormBuilder()
            ->add('search', SearchType::class)
            ->getForm();

        $form->handleRequest($req);

        $maxResults = 10;
        $firstResult = $maxResults * ($page - 1);

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->getData();

            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->search($query['search'], $firstResult, $maxResults);
        } else {
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->getPaginated($firstResult, $maxResults);
        }

        $totalResults = count($products);
        $totalPages = 1;
        if ($totalResults > 0) {
            $totalPages = ceil($totalResults / $maxResults);
        }

        return $this->render('front_office/product_category.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'total_pages' => $totalPages,
            'current_page' => $page,
        ]);
    }

    /**
     * @Route("/product", name="fo_product_show")
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBySlug($slug);

        if (!$product) {
            throw $this->createNotFoundException();
        }

        return $this->render('front_office/product.html.twig', [
            'product' => $product,
        ]);
    }
}

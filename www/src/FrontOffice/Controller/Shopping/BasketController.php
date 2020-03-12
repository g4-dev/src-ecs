<?php

namespace FrontOffice\Controller\Shopping;

use Admin\Entity\Product;
use Admin\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FrontOffice\Controller\AbstractController;
use FrontOffice\Entity\Basket;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BasketController extends AbstractController
{
    private Basket $basket;
    
    private $productRepository;
    
    public function __construct(
       EntityManagerInterface $objectManager,
       ProductRepository $productRepository
    ) {
        $this->basket = new Basket($objectManager);
        $this->productRepository = $productRepository;
    }
    
    /**
     * @Route("/basket", name="basket")
     */
    public function showAction()
    {
        $products = [];
        $totalPrice = 0;
        
        if ($this->basket->hasProducts()) {
            $products = $this->basket->getProducts();
            $totalPrice = $this->basket->totalPrice($products);
        }
        
        $productsWithQuantity = [];
        foreach ($products as $product) {
            $productsWithQuantity[] = [
               'product' => $product,
               'quantity' => $this->basket->getQuantity($product)
            ];
        }
        
        return $this->render(
           'front_office/shopping/basket.html.twig',
           [
              'products' => $productsWithQuantity,
              'totalPrice' => $totalPrice,
           ]
        );
    }
    
    /**
     * @Route("/basket/add/", name="basketAdd")
     * @return RedirectResponse
     */
    public function addBasket(Request $req)
    {
        $payload = $req->get('add_to_basket');
        $id = (int) $payload['product_id'];
        $quantity = (int) $payload['quantity'];
        
        if(!$id && $quantity < 1) {
          $this->createNotFoundException();
        }
        
        $product = $this->productRepository->find($id);
    
        foreach (range(1, $quantity) as $i) {
            if ($product->getStock() > 1) {
                $this->basket->add($product);
            } else {
                $this->addFlash('primary', 'Le produit n\'est plus en stock');
                break;
            }
        }

        return $this->redirectToRoute('basket');
    }
    
    /**
     * @Route("/basket/remove/{id?}", name="basketRemove", requirements={"page": "\d+"})
     * @param $id
     * @return RedirectResponse
     */
    public function removeBasketAction(int $id = -1): RedirectResponse
    {
        if ($id === -1) {
            $this->basket->clear();
        }
        
        $product = $this->getDoctrine()
           ->getRepository(Product::class)
           ->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException();
        }
        
        $this->basket->remove($product);
        
        return $this->redirectToRoute('basket');
    }
    
    /**
     * @Route("/basket/update", name="basketUpdate")
     * @param Request $req
     * @return JsonResponse
     */
    public function updateAction(Request $req)
    {
        $data = json_decode($req->getContent(), true);
        $id = (int)$data['id'];
        $quantity = (int)$data['quantity'];
        
        $product = $this->getDoctrine()
           ->getRepository(Product::class)
           ->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException();
        }
        
        $this->basket->update($product, $quantity);
        
        $products = $this->basket->getProducts();
        $totalPrice = $this->basket->totalPrice($products);
        
        return new JsonResponse(
           [
              'price' => $product->calcTotalPrice(),
              'totalPrice' => $totalPrice,
           ]
        );
    }
    
    public function productCount()
    {
        return new Response(count($this->basket));
    }
}

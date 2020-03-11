<?php
namespace FrontOffice\Controller\Shopping;

use FrontOffice\Entity\Basket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Admin\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BasketController extends AbstractController
{
    private Basket $basket;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->basket = new Basket($objectManager);
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

        return $this->render('front_office/shopping/basket.html.twig', [
            'products' => $products,
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * @Route("/basket/add/{product}", name="basketAdd")
     * @IsGranted("ROLE_USER")
     * @param $id
     * @return RedirectResponse
     */
    public function addBasketAction($product)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($product);
        
        if (!$product) {
            throw $this->createNotFoundException();
        }

        if ($product->getStock() > 1) {
            $this->basket->add($product);
        } else {
            $this->addFlash('primary', 'Le produit n\'est plus en stock');
        }
        
        return $this->redirectToRoute('productShow', [
            'slug' => $product->getSlug(),
        ]);
    }

    /**
     * @Route("/basket/remove/{id}", name="basketRemove", requirements={"page": "\d+"})
     * @param $id
     * @return RedirectResponse
     */
    public function removeBasketAction(int $id): RedirectResponse
    {
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
        $id = (int) $data['id'];
        $quantity = (int) $data['quantity'];
       
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException();
        }

        $this->basket->update($product, $quantity);
            
        $products = $this->basket->getProducts();
        $totalPrice = $this->basket->totalPrice($products);

        return new JsonResponse([
            'price' => $product->calcTotalPrice(),
            'totalPrice' => $totalPrice,
        ]);
    }

    public function productCount()
    {
        return new Response(count($this->basket));
    }
}

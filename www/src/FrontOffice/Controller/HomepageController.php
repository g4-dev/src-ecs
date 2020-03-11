<?php

namespace FrontOffice\Controller;

use Admin\Entity\CmsPage;
use Admin\Entity\Diy;
use Admin\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(Request $req): Response
    {
        $purchase = $req->get('purchase');
        
        $cmsPages = $this->getDoctrine()->getRepository(CmsPage::class)
           ->findBy(['onHome' => true],null,5);
    
        $products = $this->getDoctrine()->getRepository(Product::class)
           ->findLatest(4);
    
        $diys = $this->getDoctrine()->getRepository(Diy::class)
           ->findLatest(4);
        
        dump($diys);
        dump($cmsPages);
        dump($products);
        
        return $this->render(
           'front_office/homepage.html.twig',
           [
              'purchase' => $purchase,
              'products' => $products,
              'cmsPages' => $cmsPages,
              'diys' => $diys
           ]
        );
    }
    
    public function navWalker()
    {
    
    }
}

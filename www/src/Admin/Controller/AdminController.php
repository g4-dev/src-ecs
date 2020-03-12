<?php

namespace Admin\Controller;

use Admin\Entity\Diy;
use Admin\Entity\Product;
use FrontOffice\Entity\Purchase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;

class AdminController extends EasyAdminController
{
    use AdminTrait;

    /**
     * @Route("/", name="easyadmin")
     * @Route("/", name="admin")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }
    
    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $productRepo = $em->getRepository(Product::class);
        $diyRepo = $em->getRepository(Diy::class);
        $puchaseRepo = $em->getRepository(Purchase::class);
        
        // TODO: add list of 5-6 data to loop in in template
        return $this->render('@admin/dashboard.html.twig', [
           'lastProducts' => $productRepo->findLatest(7),
           'lastDiy' => $diyRepo->findLatest(7),
           'lastPurchases' => $puchaseRepo ->findLatest(15),
        ]);
    }
}

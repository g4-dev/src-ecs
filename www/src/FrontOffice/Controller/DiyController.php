<?php


namespace FrontOffice\Controller;

use Admin\Entity\Diy;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiyController extends AbstractController
{
    /**
     * @Route("/diy/list/{page?1}", name="diyList", requirements={"slug"="^[A-Za-z0-9-]*$"})
     */
    public function listAction(int $page = 1) : Response
    {
        // TODO: prendre le code de easyadmin pour faire la pagination
        // Pagination de tout
        // En ajax si possible
        $qb = $this->getDoctrine()
           ->getRepository(Diy::class)
           ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(1 === $page ? 4 : 10);
        $pagerfanta->setCurrentPage($page);
        dump($pagerfanta->getIterator());
        //TODO : remove
        dump($pagerfanta);
        
        return $this->render('front_office/cms/diyList.html.twig',[
            'diys' => $pagerfanta
        ]);
    }
    /**
     * @Route("/diy/{slug}", name="diyShow", requirements={"slug"="^[A-Za-z0-9-]*$"})
     */
    public function showAction($slug)
    {
        $diy = $this->getDoctrine()
           ->getRepository(Diy::class)
           ->findOneBySlug($slug);
    
        if (!$diy) {
            return $this->redirectToRoute('diyList');
        }
        return $this->render('front_office/cms/diyShow.html.twig', [
           'diy' => $diy
        ]);
    }
}

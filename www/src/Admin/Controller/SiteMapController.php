<?php

namespace Admin\Controller;

use Admin\Service\SiteMapService;
use Core\Service\AdminService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Request;
use Core\Entity\NavWalker;

class SiteMapController extends EasyAdminController
{

    public SiteMapService $siteMapService;

    public function getSiteMap(Request $request,SiteMapService $siteMapService)
    {
        return $siteMapService->getSiteMap($request);
    }

    public function setFormEditWalker()
    {
        $this->editAction();
    }

    public function setFormCreateWalker()
    {
        $this->newAction();
    }





}

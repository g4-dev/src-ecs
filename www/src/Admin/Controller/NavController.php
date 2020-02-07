<?php

namespace Admin\Controller;

use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Request;

class NavController extends EasyAdminController
{
    
    public function setFormEditWalker()
    {
        parent::editAction();
    }
    
    public function setFormCreateWalker()
    {
        parent::newAction();
    }
}
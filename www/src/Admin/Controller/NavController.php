<?php


namespace Admin\Controller;

use Admin\Entity\Nav;
use Admin\Repository\NavRepository;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;

class NavController extends EasyAdminController
{
    private $navRepo;
    
    public function __construct(NavRepository $navRepo)
    {
        $this->navRepo = $navRepo;
    }
    
    public function createNavEntityFormBuilder($entity, $view)
    {
        dump("bite");
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        
        // Here I overwrite field to be disabled
        //$formBuilder->add('directory', TextType::class, ['disabled' => true]);
        
        return $formBuilder;
    }
    
    /**
     * Override for soft delete.
     * @param object $entity
     */
/*    protected function removeEntity($entity)
    {
        if (method_exists($entity, 'setIsDeleted')) {
            $entity->setIsDeleted(true);
        }
        $this->updateEntity($entity);
    }*/
}
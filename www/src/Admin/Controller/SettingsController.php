<?php

namespace Admin\Controller;

use Admin\Entity\CmsPage;
use Admin\Entity\Diy;
use Admin\Entity\Settings;
use Admin\Entity\Product;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends EasyAdminController
{
    const UNIQUE_ROW_ID  = 1;
    
    protected function initialize(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actualSettings = $this->getDoctrine()->getRepository(Settings::class)
              ->find(self::UNIQUE_ROW_ID) ?? null;
    
        if($actualSettings){
            parent::initialize($request);
            return;
        }
    
        $settings = (new Settings())
           ->setHomeProducts($this->getLastItems(Product::class, 4))
           ->setHomeDiys($this->getLastItems(Diy::class, 4))
           ->setHeadlineCmsPages($this->getLastItems(CmsPage::class,2))
           ->setFooterPages($this->getLastItems(CmsPage::class,2))
           ->setId();
    
        $em->persist($settings);
        $em->flush();
    
        parent::initialize($request);
    }
    
    public function getLastItems($entity, $qty){
        return $this->getDoctrine()->getRepository($entity)->findBy(
           [],
           ['createdAt' => 'ASC', 'id' => 'ASC'],
           $qty,
           0
        );
    }
}
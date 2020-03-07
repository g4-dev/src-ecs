<?php

namespace Admin\Controller;

use Admin\Command\InitSettingsCommand;
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
        $actualSettings = $this->getDoctrine()->getRepository(Settings::class)
              ->find(self::UNIQUE_ROW_ID) ?? null;
    
        if($actualSettings){
            parent::initialize($request);
            return;
        }
    
        (new InitSettingsCommand($this->getDoctrine()))->execute(null, null);
    
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
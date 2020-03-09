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
    
    public function editSettingsAction()
    {
        return parent::editAction();
    }
    
    protected function updateSettingsEntity(Settings $settings)
    {
        foreach ($settings->getHomeCmsPages() as $item)
        {
            $item->setSettingHome($settings);
            $this->updateEntity($item);
            $this->persistEntity($item);
        }
    
        foreach ($settings->getHomeDiys() as $item)
        {
            $item->setSettingHome($settings);
            $this->updateEntity($item);
            $this->persistEntity($item);
        }
    
        foreach ($settings->getHomeProducts() as $item)
        {
            $item->setSettingHome($settings);
            $this->updateEntity($item);
            $this->persistEntity($item);
        }
        
        $this->updateEntity($settings);
    }
}
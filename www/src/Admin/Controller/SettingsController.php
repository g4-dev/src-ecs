<?php

namespace Admin\Controller;

use Admin\Entity\CmsPage;
use Admin\Entity\Settings;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;

class SettingsController extends EasyAdminController
{
    
    public function editSettingsAction()
    {
        return parent::editAction();
    }
    
    protected function updateSettingsEntity(Settings $settings)
    {
        $em = $this->getDoctrine();
        foreach ($settings->getHomeCmsPages() as $item)
        {
            dump($em->getRepository(CmsPage::class)->find($item->getId()));
            dump($settings->getHomeCmsPages());
            $item->setSettingHome($settings);
            $this->updateEntity($item);
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
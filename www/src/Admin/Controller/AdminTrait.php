<?php

namespace Admin\Controller;

use Core\Entity\Admin;
use Core\Service\AdminService;

trait AdminTrait
{
    public AdminService $adminService;
    
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    
    protected function createNewAdminEntity()
    {
        return $this->getAdminService()->create('', '');
    }

    protected function persistAdminEntity(Admin $user)
    {
        $this->encodeAdminPassword($user);
        $this->persistEntity($user);
    }

    protected function updateAdminEntity(Admin $user)
    {
        $this->encodeAdminPassword($user);
        $this->updateEntity($user);
    }

    protected function encodeAdminPassword(Admin $user)
    {
        $user->setPasswordHash($this->getAdminService()->encodePassword($user, $user->getPasswordHash()));
    }

    protected function getAdminService(): AdminService
    {
        return $this->adminService;
    }
    
    protected function setAdminService(AdminService $adminService)
    {
        return $this->adminService = $adminService;
    }
}

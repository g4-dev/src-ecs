<?php

namespace Fixtures\DataFixtures\Prod;

use Doctrine\Common\Persistence\ObjectManager;
use Fixtures\AbstractFixture;

class AdminFixtures extends AbstractFixture
{
    public function load(ObjectManager $om)
    {
        $service = $this->container->get('core.admin');

        $admin = $service->create('admin-ecs@yopmail.com', 'Azerty69')
            ->setName('System Admin');
        $admin->addRole('ROLE_SUPERADMIN');

        $service->save($admin);
    }

    public function getOrder()
    {
        return 1;
    }
}

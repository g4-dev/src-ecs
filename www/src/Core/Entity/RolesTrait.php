<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

trait RolesTrait
{
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::DEFAULT_ROLE;
        
        return array_unique($roles);
    }
}
<?php

namespace Core\Entity\Traits;

trait Roles
{
    public function getRoles(): array
    {
        return $this->roles;
    }
    
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
    
    public function addRole(string $newRole)
    {
        $this->roles[] = $newRole;
    }

    public function removeRole(string $oldRole)
    {
        $this->roles = array_diff($this->roles, [$oldRole]);
    }
}
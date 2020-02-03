<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\AdminRepository")
 * @ORM\Table(name="admin")
 */
class Admin extends AbstractUser implements UserInterface
{
    const DEFAULT_ROLE = 'ROLE_ADMIN';
    
    /**
     * @var array
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private array $roles = [self::DEFAULT_ROLE];
    
    use Traits\Roles;
    use Traits\CreatedAt;
    
    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getPassword()
    {
        return $this->getPasswordHash();
    }

    public function getSalt()
    {
        // Do nothing.
    }

    public function eraseCredentials()
    {
        // Do nothing.
    }
}

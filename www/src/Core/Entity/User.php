<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends AbstractUser implements UserInterface
{
    const DEFAULT_ROLE = 'ROLE_USER';
    
    use UniqueIdTrait;
    
    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=32, nullable=true, unique=false)
     */
    protected $token;
    
    /**
     * @var array
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private array $roles = [self::DEFAULT_ROLE];
    
    use RolesTrait;
    
    public function setToken(string $token)
    {
        $this->token = $token;
        
        return $this;
    }
    
    public function getToken()
    {
        return $this->token;
    }
    
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

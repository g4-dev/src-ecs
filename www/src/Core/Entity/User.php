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

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=32, nullable=false, unique=false)
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255, nullable=false, unique=false)
     */
    private string $address;

    /**
     * @var string
     * @ORM\Column(name="company_name", type="string", length=50, nullable=true, unique=false)
     */
    private string $companyName;

    /**
     * @var string
     * @ORM\Column(name="phone_number", type="string", length=10, nullable=true, unique=false)
     */
    private string $phoneNumber;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}

<?php

namespace Core\Entity\Traits;
use Symfony\Component\Validator\Constraints as Assert;

trait PersonNames
{
    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=32, nullable=false, unique=false)
     * @Assert\NotBlank()
     */
    private $firstName;
    
    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=32, nullable=false, unique=false)
     * @Assert\NotBlank()
     */
    private $lastName;
    
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    
    /**
     * @param string $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
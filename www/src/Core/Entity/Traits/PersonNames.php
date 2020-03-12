<?php

namespace Core\Entity\Traits;
use Symfony\Component\Validator\Constraints as Assert;

trait PersonNames
{
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=32, nullable=false, unique=false)
     * @Assert\NotBlank()
     */
    private $name;
    
    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=32, nullable=false, unique=false)
     * @Assert\NotBlank()
     */
    private $lastName;
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(?string $firstName): self
    {
        $this->name = $firstName;
        
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
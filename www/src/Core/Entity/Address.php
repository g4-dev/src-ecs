<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\AddressRepository")
 * @ORM\Table(name="user_addresses")
 * @UniqueEntity("phoneNumber")
 * @ORM\HasLifecycleCallbacks
 */
class Address
{
    const TYPE_BILLING = 'billing';
    const TYPE_SHIPPING = 'shipping';

    use Traits\DatesAt;
    use Traits\PersonNames;
    use Traits\Id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $address;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressComplement;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $postCode;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $country;
    
    /**
     * @var string
     * @ORM\Column(name="phone_number", type="string", length=10, nullable=true, unique=true)
     * @Assert\NotBlank()
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\User", inversedBy="addresses")
     * @ORM\JoinColumn(name="user_id", nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $type;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }
    
    public function getAddressComplement()
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement)
    {
        $this->addressComplement = $addressComplement;
        
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(?int $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }
    
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
    
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}

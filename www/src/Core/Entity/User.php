<?php

namespace Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FrontOffice\Entity\Purchase;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="user",
 *     options={"row_format":"DYNAMIC"},
 * )
 * @Vich\Uploadable()
 */
class User extends Model\AbstractUser implements UserInterface
{
    const DEFAULT_ROLE = 'ROLE_USER';
    
    use Traits\UniqueId;
    
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
    
    use Traits\Roles;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=32, nullable=false, unique=false)
     */
    private string $firstName;
    
    /**
     * @var string
     * @ORM\Column(name="company_name", type="string", length=50, nullable=true, unique=false)
     */
    private $companyName;

    /**
     * @var string
     * @ORM\Column(name="phone_number", type="string", length=10, nullable=true, unique=true)
     */
    private $phoneNumber;
    
    /**
     * @var Purchase[]
     *
     * @ORM\OneToMany(targetEntity="FrontOffice\Entity\Purchase", mappedBy="buyer", cascade={"remove"})
     */
    private $purchases;
    
    /**
     * @var Address[]
     * @ORM\OneToMany(targetEntity="Core\Entity\Address", mappedBy="user", orphanRemoval=true, cascade={"remove"})
     */
    private $addresses;
    
    /**
     * It only stores the name of the file which stores the contract subscribed
     * by the user.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $contract;
    
    /**
     * This unmapped property stores the binary contents of the file which stores
     * the contract subscribed by the user.
     *
     * @Vich\UploadableField(mapping="user_contracts", fileNameProperty="contract")
     *
     * @var File
     */
    private $contractFile;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
        $this->addresses = new ArrayCollection();
    }
    
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

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
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

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setBuyer($this);
        }

        return $this;
    }

    /**
     * @param Purchase[] $purchases
     */
    public function setPurchases($purchases)
    {
        $this->purchases = $purchases;
    }
    
    /**
     * @return Purchase[]
     */
    public function getPurchases()
    {
        return $this->purchases;
    }
    
    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }
    
    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setUser($this);
        }
        
        return $this;
    }
    
    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }
        
        return $this;
    }
    
    /**
     * @param File $contract
     */
    public function setContractFile(File $contract = null)
    {
        $this->contractFile = $contract;
    }
    
    /**
     * @return File
     */
    public function getContractFile()
    {
        return $this->contractFile;
    }
    
    /**
     * @param string $contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
    }
    
    /**
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }
}

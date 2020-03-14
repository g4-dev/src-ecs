<?php

namespace Core\Entity;

use Admin\Entity\Letter;
use Core\Entity\Traits\IsActive;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\AdminRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="admin")
 */
class Admin extends Model\AbstractUser implements UserInterface
{
    const DEFAULT_ROLE = 'ROLE_ADMIN';
    
    use Traits\Name;
    
    /**
     * @var                      array
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private array $roles = [self::DEFAULT_ROLE];

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Letter", mappedBy="admin")
     * @ORM\JoinColumn(nullable=true)
     */
    private $letters;
    
    use Traits\Roles;
    use Traits\DatesAt;
    use IsActive;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
        $this->letters = new ArrayCollection();
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

    /**
     * @return Collection|Letter[]
     */
    public function getLetters(): Collection
    {
        return $this->newsLetters;
    }

    public function addLetter(Letter $newsLetter): self
    {
        if (!$this->letters->contains($newsLetter)) {
            $this->letters[] = $newsLetter;
            $newsLetter->addAdmin($this);
        }

        return $this;
    }

    public function removeLetter(Letter $newsLetter): self
    {
        if ($this->letters->contains($newsLetter)) {
            $this->letters->removeElement($newsLetter);
            $newsLetter->removeAdmin($this);
        }

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}

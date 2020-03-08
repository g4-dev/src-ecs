<?php

namespace Core\Entity;

use Admin\Entity\NewsLetter;
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
    
    /**
     * @var array
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private array $roles = [self::DEFAULT_ROLE];

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\NewsLetter", mappedBy="admin")
     * @ORM\JoinColumn(nullable=true)
     */
    private $newsLetters;
    
    use Traits\Roles;
    use Traits\DatesAt;
    use IsActive;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
        $this->newsLetters = new ArrayCollection();
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
     * @return Collection|NewsLetter[]
     */
    public function getNewsLetters(): Collection
    {
        return $this->newsLetters;
    }

    public function addNewsLetter(NewsLetter $newsLetter): self
    {
        if (!$this->newsLetters->contains($newsLetter)) {
            $this->newsLetters[] = $newsLetter;
            $newsLetter->addAdmin($this);
        }

        return $this;
    }

    public function removeNewsLetter(NewsLetter $newsLetter): self
    {
        if ($this->newsLetters->contains($newsLetter)) {
            $this->newsLetters->removeElement($newsLetter);
            $newsLetter->removeAdmin($this);
        }

        return $this;
    }
}

<?php


namespace Admin\Entity;

use Core\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="Admin\Repository\NavRepository")
 * @ORM\Table(name="nav")
 */
class Nav
{
    use Traits\Id;
    use Traits\Name;
    
    /**
     * @ORM\OneToOne(targetEntity="Core\Entity\Model\Sluggable", orphanRemoval=true, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $page;
    
    /**
     * @ORM\Column(name="position", type="integer", nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    private $position;
    
    public function getPage(): ?object
    {
        return $this->page;
    }
    
    public function setPage(object $sluggableEntity): self
    {
        $this->page = $sluggableEntity;
        
        return $this;
    }
    
    public function getPosition(): ?int
    {
        return $this->position;
    }
    
    public function setPosition(int $position): self
    {
        $this->position = $position;
        
        return $this;
    }
}
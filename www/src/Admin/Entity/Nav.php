<?php


namespace Admin\Entity;


use Core\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Admin\Repository\NavRepository")
 * @ORM\Table(name="nav")
 */
class Nav
{
    use Traits\Id;
    use Traits\Name;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $position;
    
    /**
     * @ORM\OneToOne(targetEntity="Core\Entity\Model\Sluggable")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;
    
    public function getPosition(): ?int
    {
        return $this->position;
    }
    
    public function setPosition(int $position): self
    {
        $this->position = $position;
        
        return $this;
    }
    
    public function getPage(): ?object
    {
        return $this->page;
    }
    
    public function setPage(object $sluggableEntity): self
    {
        $this->page = $sluggableEntity;
        
        return $this;
    }
}
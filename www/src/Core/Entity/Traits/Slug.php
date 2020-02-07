<?php


namespace Core\Entity\Traits;

use Core\Helper\RandomIdGenerator;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Core\Helper\Slugger;

trait Slug
{
    /**
     * @var string
     * @ORM\Column(type="text", length=32, unique=true, nullable=true)
     */
    private $slug;
    
    public function getSlug(): string
    {
        return $this->slug;
    }
    
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        
        return $this;
    }
    
    /**
     * @ORM\PostPersist()
     */
    public function appendIdToSlug(LifecycleEventArgs $en)
    {
        if($this->getId() && !$this->slug){
            $this->setSlug($this->getId().'-'.Slugger::slugify($this));
            $en->getEntityManager()->persist($this);
        }
        
        $en->getEntityManager()->flush($this);
    }
}
<?php


namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Use an _init method in your entity constructor to set default dates
 *
 * @ORM\HasLifecycleCallbacks()
 */
trait DatesAt
{
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt = null;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt = null;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;
    
    public function _init()
    {
        $this->updatedAt = new \DateTime('now');
        $this->createdAt = new \DateTime('now');
        $this->deletedAt = null;
    }
    
    public function setCreatedAt($datetime)
    {
        if ($datetime instanceof \DateTime) {
            $this->createdAt = $datetime;
        } else {
            $this->createdAt = new \DateTime();
        }
        
        return $this;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function onPrePersistSetCreatedAt()
    {
        $this->createdAt = $this->createdAt ?? new \DateTime();
    }
    
    public function setUpdatedAt(?\DateTime $datetime)
    {
        $this->updatedAt = $datetime ?? new \DateTime('now');;
        
        return $this;
    }
    
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function onPrePersistSetUpdatedDate()
    {
        $this->updatedAt = $this->updatedAt ?? new \DateTime('now');
    }
    
    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    
    /**
     * @param mixed $deletedAt
     * @return self
     */
    public function setDeletedAt(?\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
}
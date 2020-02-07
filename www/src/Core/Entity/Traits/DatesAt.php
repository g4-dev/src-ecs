<?php


namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

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
    
    public function _init(){
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
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
    public function onPrePersistSetCreatedDate()
    {
        $this->createdAt = new \DateTime();
    }
    
    public function setUpdatedAt($datetime)
    {
        if ($datetime instanceof \DateTime) {
            $this->updatedAt = $datetime;
        } else {
            $this->updatedAt = new \DateTime();
        }
        
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
        $this->updatedAt = new \DateTime();
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
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
}
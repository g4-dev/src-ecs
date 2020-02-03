<?php

namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CreatedAt
{
    
    public function __construct() {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
    
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true )
     */
    private $updatedAt;

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
     * @ORM\PrePersist
     */
    public function onPrePersistSetRegistrationDate()
    {
        $this->createdAt = new \DateTime();
    }
}

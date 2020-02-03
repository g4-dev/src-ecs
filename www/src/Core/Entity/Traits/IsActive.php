<?php

namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IsActive
{
    /**
     * @var bool
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    protected $isActive = true;


    public function setIsActive(bool $bool)
    {
        $this->isActive = $bool;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}

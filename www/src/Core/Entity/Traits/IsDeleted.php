<?php

namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IsDeleted
{
    /**
     * @var bool
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    protected $isDeleted = false;


    public function setIsDeleted(bool $bool)
    {
        $this->isDeleted = $bool;
        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }
}

<?php

namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Name
{
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    protected $name;

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}

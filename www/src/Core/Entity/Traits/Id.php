<?php

namespace Core\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Id
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id = null;

    public function getId()
    {
        return $this->id;
    }
}

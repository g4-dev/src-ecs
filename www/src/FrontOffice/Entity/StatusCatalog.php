<?php

namespace FrontOffice\Entity;

use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * StatusCatalog
 *
 * @ORM\Table(name="status_catalog")
 * @ORM\Entity
 */
class StatusCatalog
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="status_name", type="string", length=255, nullable=false)
     */
    private $statusName;

    public function getStatusName(): ?string
    {
        return $this->statusName;
    }

    public function setStatusName(string $statusName): self
    {
        $this->statusName = $statusName;

        return $this;
    }


}

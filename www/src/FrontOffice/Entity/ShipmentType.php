<?php

namespace FrontOffice\Entity;

use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentType
 *
 * @ORM\Table(name="shipment_type")
 * @ORM\Entity
 */
class ShipmentType
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="type_name", type="string", length=64, nullable=false)
     */
    private $typeName;
    
    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;

        return $this;
    }


}

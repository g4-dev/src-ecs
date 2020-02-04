<?php

namespace Admin\Entity;

use Core\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProductType
 *
 * @ORM\Table(name="product_type")
 * @ORM\Entity
 */
class ProductType
{
    use Traits\Id;
    
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

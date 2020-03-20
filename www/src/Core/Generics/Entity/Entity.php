<?php

namespace Core\Generics\Entity;

class Entity implements PopulateInterface, ToArrayInterface
{
    use PopulateTrait;
    use ToArrayTrait;
    
    public function __construct($collection = null)
    {
        $this->populate($collection);
    }
}

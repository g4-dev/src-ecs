<?php

namespace Core\Generics\Entity;

interface PopulateInterface
{
    /**
     * Populate object by a collection.
     *
     * @param  CollectionInterface|array $collection
     * @return PopulateInterface
     */
    public function populate($collection);
}

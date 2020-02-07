<?php

namespace Core\Entity\Model;


interface Sluggable
{
    public function getName();
    
    public function getId();
    
    public function getSlug();
}
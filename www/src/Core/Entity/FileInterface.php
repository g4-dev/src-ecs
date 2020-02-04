<?php


namespace Core\Entity;



use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;

interface FileInterface
{
    public function setFile(?File $imageFile = null);
    
    public function getFile(): ?File;
    
    public function setEmbeddedFile(EmbeddedFile $embeddedFile): void;
    
    public function getEmbeddedFile(): ?EmbeddedFile;
}
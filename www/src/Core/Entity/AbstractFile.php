<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Represents an File.
 *
 * @Vich\Uploadable
 * @ORM\Entity
 * @ORM\Table(name="ecs_file")
 */
class AbstractFile
{
    use Traits\Id;
    
    /**
     *
     * @Vich\UploadableField(mapping="files", fileNameProperty="file.name", size="file.size", mimeType="image.mimeType", originalName="file.originalName")
     *
     * @var File|null
     */
    private $file;
    
    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $embeddedFile;
    
    /**
     * @param File|UploadedFile|null $imageFile
     */
    public function setFile(?File $file = null)
    {
        $this->file = $file;
        
        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }
    
    public function getFile(): ?File
    {
        return $this->file;
    }
    
    public function setEmbeddedFile(EmbeddedFile $embeddedFile): void
    {
        $this->embeddedFile = $embeddedFile;
    }
    
    public function getEmbeddedFile(): ?EmbeddedFile
    {
        return $this->embeddedFile;
    }
    
    use Traits\CreatedAt;
    
}
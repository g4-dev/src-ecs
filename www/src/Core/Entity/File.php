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
 */
class FileGeneric
{
    use Traits\Id;
    
    /**
     *
     * @Vich\UploadableField(mapping="files", fileNameProperty="fileName", size="fileSize", originalName="fileOriginalName", mimeType="fileMimeType")
     *
     * @var File|null
     */
    private $file;
    
    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $ecsFile;
    
    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $fileName;
    
    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $fileOriginalName;
    
    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $fileMimeType;
    
    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $fileSize;
    
    /**
     * @ORM\Column(type="array", nullable=true)
     *
     * @var array|null
     */
    private $fileDimensions;
    
    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $fullPath;
    
    /**
     * @param File|UploadedFile|null $imageFile
     */
    public function setFile(?File $ecsFile = null)
    {
        dump($ecsFile);
        //die;
        
        if (null !== $ecsFile) {
            // $this->setFileSize($ecsFile->getSize());
            // $this->setFileName($ecsFile->getName());
            $this->file = $ecsFile;
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }
    
    public function getFile(): ?File
    {
        return $this->file;
    }
    
    public function setEcsFile(EmbeddedFile $embeddedFile)
    {
        $this->ecsFile = $embeddedFile;
    }
    
    public function getEcsFile(): ?EmbeddedFile
    {
        return $this->ecsFile;
    }
    
    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }
    
    /**
     * @param string|null $fileName
     */
    public function setFileName(?string $fileName): void
    {
        $this->fileName = $fileName;
    }
    
    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }
    
    /**
     * @param int|null $fileSize
     * @return File
     */
    public function setFileSize(?int $fileSize): self
    {
        $this->fileSize = $fileSize;
        
        return $this;
    }
    
    use Traits\CreatedAt;

    public function getFileOriginalName(): ?string
    {
        return $this->fileOriginalName;
    }

    public function setFileOriginalName(string $fileOriginalName): self
    {
        $this->fileOriginalName = $fileOriginalName;

        return $this;
    }

    public function getFileMimeType(): ?string
    {
        return $this->fileMimeType;
    }

    public function setFileMimeType(string $fileMimeType): self
    {
        $this->fileMimeType = $fileMimeType;

        return $this;
    }

    public function getFileDimensions(): ?array
    {
        return $this->fileDimensions;
    }

    public function setFileDimensions(array $fileDimensions): self
    {
        $this->fileDimensions = $fileDimensions;

        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getFullPath(): ?string
    {
        return $this->fullPath;
    }
    
    /**
     * @param string|null $fullPath
     * @return File
     */
    public function setFullPath(?string $fullPath): File
    {
        $this->fullPath = $fullPath;
        
        return $this;
    }
    
    /**
     * @ORM\PostPersist
     */
    public function OnPostPersistSetFullPath()
    {
        //$this->fullPath = $this->session->get();
    }
    
    
}
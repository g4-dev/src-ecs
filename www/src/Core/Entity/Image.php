<?php


namespace Core\Entity;

use Core\Entity\Traits\Id;
use Core\Entity\Traits\Name;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Vich\Uploadable
 */
class Image
{
    use Id;
    use Name;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $image;
    
    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="default_images", fileNameProperty="image")
     */
    private $imageFile;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", length=255)
     */
    private $updatedAt;
    
    /**
     * @param File|null $image
     * @return Image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
        
        return $this;
    }
    
    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
    
    /**
     * @param string $image
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
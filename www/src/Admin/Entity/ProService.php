<?php


namespace Admin\Entity;

use Core\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class pro.
 *
 * @ORM\Entity
 * @ORM\Table(name="pro_service")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class ProService
{
    use Traits\Id;
    use Traits\Name;
    use Traits\DatesAt;
    use Traits\IsActive;
    
    /**
     * List of tags associated to the product.
     *
     * @var string[]
     * @ORM\Column(type="simple_array")
     */
    private $tags = array();

    /**
     * It only stores the name of the image associated with the product.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $image;

    /**
     * This unmapped property stores the binary contents of the image file
     * associated with the product.
     *
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * The price of the product.
     *
     * @var float
     * @ORM\Column(type="float")
     */
    private $price = 0.0;

    /**
     * The description of the product.
     *
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * The description of the product.
     *
     * @var string
     * @ORM\Column(type="text")
     */
    private $shortDescription;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
    }

    /**
     * Set the description of the product.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * The the full description of the product.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param File $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
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
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the price.
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get the price of the product.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the list of the tags.
     *
     * @param \string[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Get the list of tags associated to the product.
     *
     * @return \string[]
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * @return string
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }
    
    /**
     * @param string $shortDescription
     * @return ProService
     */
    public function setShortDescription(?string $shortDescription): ProService
    {
        $this->shortDescription = $shortDescription;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }
}

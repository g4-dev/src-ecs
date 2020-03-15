<?php
namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

trait TraitCategory
{
    
    /**
     * It only stores the name of the image associated with the product.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $image;
    
    /**
     * This unmapped property stores the binary contents of the image file
     * associated with the product.
     *
     * @Vich\UploadableField(mapping="default_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;
    
    /**
     * The description of the product.
     *
     * @var                     string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }
    
    /**
     * @param File|null $image
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
    
    /**
     * Set the parent category.
     *
     * @param ProductCategory $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    
    /**
     * Get the parent category.
     *
     * @return ProductCategory
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    public function getItems()
    {
        return $this->items;
    }
    
    public function setItems($items)
    {
        $this->items->clear();
        $this->items = new ArrayCollection($items);
    }
    
    /**
     * Add an item in the category.
     */
    public function addItem(Product $item)
    {
        if ($this->items->contains($item)) {
            return;
        }
        
        $this->items->add($item);
        $item->addCategory($this);
    }
    
    /**
     * @param Product $item
     */
    public function removeItem($item)
    {
        if (!$this->items->contains($item)) {
            return;
        }
        
        $this->items->removeElement($item);
        $item->removeCategory($this);
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
}

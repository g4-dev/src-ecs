<?php

namespace Admin\Entity;

use Core\Entity\Image;
use Core\Entity\Model\Sluggable;
use Core\Entity\Traits\DatesAt;
use Core\Entity\Traits\Id;
use Core\Generics\Collection\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Category.
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="product_category")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Admin\Repository\ProductCategoryRepository")
 * @Vich\Uploadable
 */
class ProductCategory extends AbstractSluggable
{
    use Id;
    use DatesAt;
    
    /**
     * Product in the category.
     *
     * @var Product[]
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="category")
     **/
    protected $items;

    /**
     * The category parent.
     *
     * @var ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     **/
    protected $parent;
    
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
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

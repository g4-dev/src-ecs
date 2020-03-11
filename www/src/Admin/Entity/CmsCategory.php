<?php

namespace Admin\Entity;

use Core\Entity\Image;
use Core\Entity\Traits\DatesAt;
use Core\Entity\Traits\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class CmsCategory.
 * @ORM\MappedSuperclass
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="Admin\Repository\CmsCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class CmsCategory extends AbstractSluggable
{
    use Id;
    use DatesAt;
    
    /**
     * Product in the category.
     *
     * @var CmsPage[]
     * @ORM\ManyToMany(targetEntity="CmsPage", mappedBy="category")
     **/
    protected $items;

    /**
     * The category parent.
     *
     * @var CmsCategory
     * @ORM\ManyToOne(targetEntity="CmsCategory")
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
     * @param CmsCategory $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent category.
     *
     * @return CmsCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Return all pages associated to the category.
     *
     * @return CmsPage[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set all pages in the category.
     *
     * @param CmsPage[] $products
     */
    public function setItems($items)
    {
        $this->items->clear();
        $this->items = new ArrayCollection($items);
    }

    /**
     * Add a product in the category.
     *
     * @param $product Product The product to associate
     */
    public function addItem(CmsPage $cmspage)
    {
        if ($this->items->contains($cmspage)) {
            return;
        }

        $this->items->add($cmspage);
        $cmspage->addCategory($this);
    }

    /**
     * @param Product $product
     */
    public function removeCmsPage(CmsPage $cmsPage)
    {
        if (!$this->items->contains($cmsPage)) {
            return;
        }

        $this->items->removeElement($cmsPage);
        $cmsPage->removeCategory($this);
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

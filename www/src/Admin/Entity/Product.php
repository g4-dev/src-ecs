<?php


namespace Admin\Entity;

use Core\Entity\Model\Sluggable;
use Core\Entity\Traits;
use Core\Entity\Traits\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FrontOffice\Entity\PurchaseItem;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product.
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Admin\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Product extends AbstractSluggable
{
    use Id;
    use Traits\DatesAt;
    use Traits\IsActive;
    use Traits\ImageCollection;
    
    /**
     * List of tags associated to the product.
     *
     * @var string[]
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $tags = array();

    /**
     * The EAN 13 of the product. (type set to string in PHP due to 32 bit limitation).
     *
     * @var string
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $ean;

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
     * Features of the product.
     * Associative array, the key is the name/type of the feature, and the value the data.
     * Example:<pre>array(
     *     'size' => '13cm x 15cm x 6cm',
     *     'bluetooth' => '4.1'
     * )</pre>.
     *
     * @var array
     * @ORM\Column(type="array")
     */
    private $features = array();

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
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $onHome = false;

    /**
     * List of categories where the products is
     * (Owning side).
     *
     * @var ProductCategory[]
     * @ORM\ManyToMany(targetEntity="ProductCategory", inversedBy="items")
     * @ORM\JoinTable(name="product_categories")
     */
    private $category;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $stock;
    
    /**
     * @var \FrontOffice\Entity\PurchaseItem[]
     * @ORM\OneToMany(targetEntity="FrontOffice\Entity\PurchaseItem", mappedBy="product", cascade={"remove"})
     */
    private $purchasedItems;
    
    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->purchasedItems = new ArrayCollection();
    
        method_exists($this, '_initImages') ? $this->_initImages() : null;
        method_exists($this, '_init') ? $this->_init() : null;
    }
    
    /**
     * Get all associated categories.
     *
     * @return ProductCategory[]
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Set all categories of the product.
     *
     * @param ProductCategory[] $category
     */
    public function setCategory(array $category)
    {
        $this->category->clear();
        $this->category = new ArrayCollection($category);
    }
    
    /**
     * Add a category in the product association.
     * (Owning side).
     *
     * @param $category ProductCategory the category to associate
     */
    public function addCategory($category)
    {
        if ($this->category->contains($category)) {
            return;
        }

        $this->category->add($category);
        $category->addItem($this);
    }

    /**
     * Remove a category in the product association.
     * (Owning side).
     *
     * @param $category ProductCategory the category to associate
     */
    public function removeCategory($category)
    {
        if (!$this->category->contains($category)) {
            return;
        }

        $this->category->removeElement($category);
        $category->removeItem($this);
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
     * Define the EAN code of the product.
     *
     * @param string $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }

    /**
     * Get the EAN code.
     *
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set the list of features.
     * The parameter is an associative array (key as type, value as data.
     *
     * @param array $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }

    /**
     * Get all product features.
     *
     * @return array
     */
    public function getFeatures()
    {
        return $this->features;
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
    
    public function getStock(): ?int
    {
        return $this->stock;
    }
    
    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        
        return $this;
    }
    
    /**
     * @param \FrontOffice\Entity\PurchaseItem[] $purchasedItems
     */
    public function setPurchasedItems(array $purchasedItems)
    {
        $this->purchasedItems->clear();
        $this->purchasedItems = new ArrayCollection($purchasedItems);
    }
    
    /**
     * @return \FrontOffice\Entity\PurchaseItem[]
     */
    public function getPurchasedItems()
    {
        return $this->purchasedItems;
    }

    public function addPurchasedItem(PurchaseItem $purchasedItem): self
    {
        if (!$this->purchasedItems->contains($purchasedItem)) {
            $this->purchasedItems[] = $purchasedItem;
            $purchasedItem->setProduct($this);
        }

        return $this;
    }

    public function removePurchasedItem(PurchaseItem $purchasedItem): self
    {
        if ($this->purchasedItems->contains($purchasedItem)) {
            $this->purchasedItems->removeElement($purchasedItem);
            // set the owning side to null (unless already changed)
            if ($purchasedItem->getProduct() === $this) {
                $purchasedItem->setProduct(null);
            }
        }

        return $this;
    }

    public function getOnHome(): ?bool
    {
        return $this->onHome;
    }

    public function setOnHome(bool $onHome): self
    {
        $this->onHome = $onHome;

        return $this;
    }
}

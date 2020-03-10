<?php

namespace Admin\Entity;

use Core\Entity\Model\Sluggable;
use Core\Generics\Collection\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category.
 *
 * @ORM\Table(name="product_category")
 * @ORM\Entity(repositoryClass="\Admin\Repository\CategoryRepository")
 * @ORM\MappedSuperclass
 */
class ProductCategory extends AbstractCategory implements Sluggable
{
    /**
     * Product in the category.
     *
     * @var Product[]
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="productCategories")
     **/
    protected $products;

    /**
     * The category parent.
     *
     * @var ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     **/
    protected $parent;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * Return all product associated to the category.
     *
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set all products in the category.
     *
     * @param Product[] $products
     */
    public function setProducts($products)
    {
        $this->products->clear();
        $this->products = new Collection($products);
    }

    /**
     * Add a product in the category.
     *
     * @param $product Product The product to associate
     */
    public function addProduct($product)
    {
        if ($this->products->contains($product)) {
            return;
        }

        $this->products->add($product);
        $product->addProductCategory($this);
    }

    /**
     * @param Product $product
     */
    public function removeProduct($product)
    {
        if (!$this->products->contains($product)) {
            return;
        }

        $this->products->removeElement($product);
        $product->removeProductCategory($this);
    }
}

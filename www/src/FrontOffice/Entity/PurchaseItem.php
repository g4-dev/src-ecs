<?php

namespace FrontOffice\Entity;

use Admin\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PurchaseItem.
 *
 * @ORM\Table(name="purchase_item")
 * @ORM\Entity
 */
class PurchaseItem
{
    /**
     * The identifier of the image.
     *
     * @var                                 int
     * @ORM\Column(name="id",               type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id = null;

    /**
     * The ordered quantity.
     *
     * @var                         int
     * @ORM\Column(type="smallint")
     */
    protected $quantity = 1;

    /**
     * The tax rate to apply on the product.
     *
     * @var                        string
     * @ORM\Column(type="decimal", name="tax_rate")
     */
    protected $taxRate = 0;

    /**
     * The ordered product.
     *
     * @var \Admin\Entity\Product
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Product", inversedBy="purchasedItems")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Purchase", inversedBy="purchasedItems", cascade={"persist"})
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id")
     */
    private $purchase;
    
    public function __construct(Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
    
    /**
     * @param \Admin\Entity\Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return \Admin\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Purchase $purchase
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * @return Purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return string
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getProduct()->getName().' [x'.$this->getQuantity().']: '.$this->getTotalPrice();
    }

    /**
     * Return the total price (tax included).
     *
     * @return float
     */
    public function getTotalPrice()
    {
        $taxRate = $this->taxRate ?? 0;
        
        return $this->product->getPrice() * $this->quantity * (1 + $taxRate);
    }
}

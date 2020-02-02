<?php

namespace Admin\Entity;

use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="product_product_type", columns={"product_type_id"})})
 * @ORM\Entity
 */
class Product
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=64, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_description", type="string", length=255, nullable=false)
     */
    private $productDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=16, nullable=false)
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="price_per_unit", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $pricePerUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="product_short_desc", type="text", length=65535, nullable=false)
     */
    private $productShortDesc;

    /**
     * @var int
     *
     * @ORM\Column(name="promo", type="integer", nullable=false)
     */
    private $promo;

    /**
     * @var ProductType
     *
     * @ORM\ManyToOne(targetEntity="ProductType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_type_id", referencedColumnName="id")
     * })
     */
    private $productType;
    
    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getPricePerUnit(): ?string
    {
        return $this->pricePerUnit;
    }

    public function setPricePerUnit(string $pricePerUnit): self
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    public function getProductShortDesc(): ?string
    {
        return $this->productShortDesc;
    }

    public function setProductShortDesc(string $productShortDesc): self
    {
        $this->productShortDesc = $productShortDesc;

        return $this;
    }

    public function getPromo(): ?int
    {
        return $this->promo;
    }

    public function setPromo(int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getProductType(): ?ProductType
    {
        return $this->productType;
    }

    public function setProductType(?ProductType $productType): self
    {
        $this->productType = $productType;

        return $this;
    }
}

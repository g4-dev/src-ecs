<?php

namespace FrontOffice\Entity;

use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Product;

/**
 * ShipmentDetails
 *
 * @ORM\Table(name="shipment_details", uniqueConstraints={@ORM\UniqueConstraint(name="shipmet_details_ak_1", columns={"shipment_id", "product_id"})}, indexes={@ORM\Index(name="shipmet_details_product", columns={"product_id"}), @ORM\Index(name="IDX_998E0D2F7BE036FC", columns={"shipment_id"})})
 * @ORM\Entity
 */
class ShipmentDetails
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="quanitity", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $quanitity;

    /**
     * @var string
     *
     * @ORM\Column(name="price_per_unit", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $pricePerUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var Shipment
     *
     * @ORM\ManyToOne(targetEntity="Shipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_id", referencedColumnName="id")
     * })
     */
    private $shipment;

    public function getQuanitity(): ?string
    {
        return $this->quanitity;
    }

    public function setQuanitity(string $quanitity): self
    {
        $this->quanitity = $quanitity;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getShipment(): ?Shipment
    {
        return $this->shipment;
    }

    public function setShipment(?Shipment $shipment): self
    {
        $this->shipment = $shipment;

        return $this;
    }


}

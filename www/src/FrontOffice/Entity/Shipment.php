<?php

namespace FrontOffice\Entity;

use Core\Entity\IdTrait;
use Core\Entity\User;
use Core\Entity\PaymentType;
use Doctrine\ORM\Mapping as ORM;
/**
 * Shipment
 *
 * @ORM\Table(name="shipment", indexes={@ORM\Index(name="shipment_shipment_type", columns={"shipment_type_id"}), @ORM\Index(name="shipment_client", columns={"client_id"}), @ORM\Index(name="shipment_payment_type", columns={"payment_type_id"})})
 * @ORM\Entity
 */
class Shipment
{
    use IdTrait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_created", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $timeCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_address", type="text", length=65535, nullable=false)
     */
    private $shippingAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_address", type="text", length=65535, nullable=false)
     */
    private $billingAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="products_price", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $productsPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_cost", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $deliveryCost;

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="final_price", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $finalPrice;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_type_id", referencedColumnName="id")
     * })
     */
    private $paymentType;

    /**
     * @var ShipmentType
     *
     * @ORM\ManyToOne(targetEntity="ShipmentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_type_id", referencedColumnName="id")
     * })
     */
    private $shipmentType;
    
    public function getTimeCreated(): ?\DateTimeInterface
    {
        return $this->timeCreated;
    }

    public function setTimeCreated(\DateTimeInterface $timeCreated): self
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getProductsPrice(): ?string
    {
        return $this->productsPrice;
    }

    public function setProductsPrice(string $productsPrice): self
    {
        $this->productsPrice = $productsPrice;

        return $this;
    }

    public function getDeliveryCost(): ?string
    {
        return $this->deliveryCost;
    }

    public function setDeliveryCost(string $deliveryCost): self
    {
        $this->deliveryCost = $deliveryCost;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getFinalPrice(): ?string
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(string $finalPrice): self
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPaymentType(): ?PaymentType
    {
        return $this->paymentType;
    }

    public function setPaymentType(?PaymentType $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getShipmentType(): ?ShipmentType
    {
        return $this->shipmentType;
    }

    public function setShipmentType(?ShipmentType $shipmentType): self
    {
        $this->shipmentType = $shipmentType;

        return $this;
    }


}

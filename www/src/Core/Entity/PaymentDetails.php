<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use FrontOffice\Entity\Shipment;
/**
 * PaymentDetails
 *
 * @ORM\Table(name="payment_details", indexes={@ORM\Index(name="payment_details_payment_data", columns={"payment_data_id"}), @ORM\Index(name="payment_details_shipment", columns={"shipment_id"})})
 * @ORM\Entity
 */
class PaymentDetails
{
    use IdTrait;
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var PaymentData
     *
     * @ORM\ManyToOne(targetEntity="PaymentData")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_data_id", referencedColumnName="id")
     * })
     */
    private $paymentData;

    /**
     * @var Shipment
     *
     * @ORM\ManyToOne(targetEntity="FrontOffice\Entity\Shipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_id", referencedColumnName="id")
     * })
     */
    private $shipment;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPaymentData(): ?PaymentData
    {
        return $this->paymentData;
    }

    public function setPaymentData(?PaymentData $paymentData): self
    {
        $this->paymentData = $paymentData;

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

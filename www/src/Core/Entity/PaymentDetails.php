<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use FrontOffice\Entity\Purchase;
/**
 * PaymentDetails
 *
 * @ORM\Table(name="payment_details", indexes={@ORM\Index(name="payment_details_payment_data", columns={"payment_data_id"}), @ORM\Index(name="payment_details_shipment", columns={"shipment_id"})})
 * @ORM\Entity
 */
class PaymentDetails
{
    use Traits\Id;
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
     * @var Purchase
     *
     * @ORM\ManyToOne(targetEntity="FrontOffice\Entity\Purchase")
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

    public function getPurchase(): ?Purchase
    {
        return $this->shipment;
    }

    public function setPurchase(?Purchase $shipment): self
    {
        $this->shipment = $shipment;

        return $this;
    }


}

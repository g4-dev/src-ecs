<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentData
 *
 * @ORM\Table(name="payment_data", uniqueConstraints={@ORM\UniqueConstraint(name="payment_data_ak_1", columns={"payment_type_id", "data_name"})}, indexes={@ORM\Index(name="IDX_8C706417DC058279", columns={"payment_type_id"})})
 * @ORM\Entity
 */
class PaymentData
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="data_name", type="string", length=255, nullable=false)
     */
    private $dataName;

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=255, nullable=false)
     */
    private $dataType;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_type_id", referencedColumnName="id")
     * })
     */
    private $paymentType;

    public function getDataName(): ?string
    {
        return $this->dataName;
    }

    public function setDataName(string $dataName): self
    {
        $this->dataName = $dataName;

        return $this;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): self
    {
        $this->dataType = $dataType;

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


}

<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use FrontOffice\Entity\Purchase;

/**
 * @ORM\Entity(repositoryClass="Core\Repository\TransactionRepository")
 * @ORM\Table(name="transactions")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $method;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total;

    /**
     * @ORM\OneToOne(targetEntity="FrontOffice\Entity\Purchase", inversedBy="transaction", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id", nullable=false)
     */
    private $purchase;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    public function __construct(string $method, float $total)
    {
        $this->dateCreated = new \DateTime();
        $this->total = $total;
        $this->method = $method;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}

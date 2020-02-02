<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity
 */
class Stock
{
    /**
     * @var string
     *
     * @ORM\Column(name="in_stock", type="integer", nullable=false)
     */
    private $inStock;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_time", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdateTime;

    /**
     * @var Product
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    public function getInStock(): ?string
    {
        return $this->inStock;
    }

    public function setInStock(string $inStock): self
    {
        $this->inStock = $inStock;

        return $this;
    }

    public function getLastUpdateTime(): ?\DateTimeInterface
    {
        return $this->lastUpdateTime;
    }

    public function setLastUpdateTime(\DateTimeInterface $lastUpdateTime): self
    {
        $this->lastUpdateTime = $lastUpdateTime || new \DateTime();

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
}

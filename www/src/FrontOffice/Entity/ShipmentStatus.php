<?php

namespace FrontOffice\Entity;

use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * ShipmentStatus
 *
 * @ORM\Table(name="shipment_status", indexes={@ORM\Index(name="shipment_status_shipment", columns={"shipment_id"}), @ORM\Index(name="shipment_status_status_catalog", columns={"status_catalog_id"})})
 * @ORM\Entity
 */
class ShipmentStatus
{
    use IdTrait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="status_time", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $statusTime = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", length=65535, nullable=true)
     */
    private $notes;

    /**
     * @var Shipment
     *
     * @ORM\ManyToOne(targetEntity="Shipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipment_id", referencedColumnName="id")
     * })
     */
    private $shipment;

    /**
     * @var StatusCatalog
     *
     * @ORM\ManyToOne(targetEntity="StatusCatalog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_catalog_id", referencedColumnName="id")
     * })
     */
    private $statusCatalog;

    public function getStatusTime(): ?\DateTimeInterface
    {
        return $this->statusTime;
    }

    public function setStatusTime(\DateTimeInterface $statusTime): self
    {
        $this->statusTime = $statusTime;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

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

    public function getStatusCatalog(): ?StatusCatalog
    {
        return $this->statusCatalog;
    }

    public function setStatusCatalog(?StatusCatalog $statusCatalog): self
    {
        $this->statusCatalog = $statusCatalog;

        return $this;
    }


}

<?php

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShipmentInterface;

class ShippingExport implements ShippingExportInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var ShipmentInterface
     */
    private $shipment;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $label;

    /**
     * @var ShippingExport
     */
    private $status;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ShipmentInterface
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @param ShipmentInterface $shipment
     *
     * @return ShippingExport
     */
    public function setShipment(ShipmentInterface $shipment)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return ShippingExport
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return ShippingExport
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return ShippingExport
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param ShippingExport $status
     *
     * @return ShippingExport
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
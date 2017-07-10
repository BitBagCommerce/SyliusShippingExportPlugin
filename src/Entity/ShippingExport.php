<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShipmentInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * {@inheritdoc}
     */
    public function setShipment(ShipmentInterface $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * {@inheritdoc}
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
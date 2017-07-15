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
 * @author Patryk Drapik <patryk.drapik@bitbag.psl>
 */
class ShippingExport implements ShippingExportInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ShipmentInterface
     */
    protected $shipment;

    /**
     * @var ShippingGatewayInterface
     */
    protected $shippingGateway;

    /**
     * @var \DateTime
     */
    protected $exportedAt;

    /**
     * @var string
     */
    protected $labelPath;

    /**
     * @var string
     */
    protected $state = ShippingExportInterface::STATE_NEW;

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
    public function getShipment(): ShipmentInterface
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
    public function getShippingGateway()
    {
        return $this->shippingGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingGateway(ShippingGatewayInterface $shippingGateway)
    {
        $this->shippingGateway = $shippingGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportedAt()
    {
        return $this->exportedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setExportedAt(\DateTime $exportedAt)
    {
        $this->exportedAt = $exportedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelPath()
    {
        return $this->labelPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabelPath($labelPath)
    {
        $this->labelPath = $labelPath;
    }
}
<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Entity;

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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getShipment(): ?ShipmentInterface
    {
        return $this->shipment;
    }

    /**
     * {@inheritdoc}
     */
    public function setShipment(?ShipmentInterface $shipment): void
    {
        $this->shipment = $shipment;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingGateway(): ?ShippingGatewayInterface
    {
        return $this->shippingGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingGateway(?ShippingGatewayInterface $shippingGateway): void
    {
        $this->shippingGateway = $shippingGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportedAt(): ?\DateTime
    {
        return $this->exportedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setExportedAt(?\DateTime $exportedAt): void
    {
        $this->exportedAt = $exportedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelPath(): ?string
    {
        return $this->labelPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabelPath(?string $labelPath): void
    {
        $this->labelPath = $labelPath;
    }
}

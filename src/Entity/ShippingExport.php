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

class ShippingExport implements ShippingExportInterface
{
    /** @var int */
    protected $id;

    /** @var ShipmentInterface */
    protected $shipment;

    /** @var string */
    protected $externalId;

    /** @var ShippingGatewayInterface */
    protected $shippingGateway;

    /** @var \DateTime */
    protected $exportedAt;

    /** @var string */
    protected $labelPath;

    /** @var string */
    protected $state = ShippingExportInterface::STATE_NEW;

    public function getId(): int
    {
        return $this->id;
    }

    public function getShipment(): ?ShipmentInterface
    {
        return $this->shipment;
    }

    public function setShipment(?ShipmentInterface $shipment): void
    {
        $this->shipment = $shipment;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getShippingGateway(): ?ShippingGatewayInterface
    {
        return $this->shippingGateway;
    }

    public function setShippingGateway(?ShippingGatewayInterface $shippingGateway): void
    {
        $this->shippingGateway = $shippingGateway;
    }

    public function getExportedAt(): ?\DateTime
    {
        return $this->exportedAt;
    }

    public function setExportedAt(?\DateTime $exportedAt): void
    {
        $this->exportedAt = $exportedAt;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getLabelPath(): ?string
    {
        return $this->labelPath;
    }

    public function setLabelPath(?string $labelPath): void
    {
        $this->labelPath = $labelPath;
    }
}

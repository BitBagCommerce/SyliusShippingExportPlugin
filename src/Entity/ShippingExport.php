<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShipmentInterface;

class ShippingExport implements ShippingExportInterface
{
    /** @var int */
    protected $id;

    /** @var ShipmentInterface|null */
    protected $shipment;

    /** @var string|null */
    protected $externalId;

    /** @var ShippingGatewayInterface|null */
    protected $shippingGateway;

    /** @var \DateTime|null */
    protected $exportedAt;

    /** @var string|null */
    protected $labelPath;

    /** @var string|null */
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

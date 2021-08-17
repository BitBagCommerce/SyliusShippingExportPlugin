<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ShippingExportInterface extends ResourceInterface
{
    public const STATE_NEW = 'new';

    public const STATE_EXPORTED = 'exported';

    public function getShipment(): ?ShipmentInterface;

    public function setShipment(?ShipmentInterface $shipment): void;

    public function getExternalId(): ?string;

    public function setExternalId(?string $externalId): void;

    public function getShippingGateway(): ?ShippingGatewayInterface;

    public function setShippingGateway(?ShippingGatewayInterface $shippingGateway): void;

    public function getExportedAt(): ?\DateTime;

    public function setExportedAt(?\DateTime $exportedAt): void;

    public function getLabelPath(): ?string;

    public function setLabelPath(?string $labelPath): void;

    public function getState(): ?string;

    public function setState(?string $state): void;
}

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
use Sylius\Component\Resource\Model\ResourceInterface;

interface ShippingExportInterface extends ResourceInterface
{
    const STATE_NEW = 'new';
    const STATE_EXPORTED = 'exported';

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

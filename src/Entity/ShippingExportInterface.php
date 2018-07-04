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

    /**
     * @return ShipmentInterface
     */
    public function getShipment(): ?ShipmentInterface;

    /**
     * @param ShipmentInterface $shipment
     */
    public function setShipment(?ShipmentInterface $shipment): void;

    /**
     * @return string|null
     */
    public function getShipmentGatewayId(): ?string;

    /**
     * @param string|null $shipmentGatewayId
     */
    public function setShipmentGatewayId(?string $shipmentGatewayId): void;

    /**
     * @return ShippingGatewayInterface
     */
    public function getShippingGateway(): ?ShippingGatewayInterface;

    /**
     * @param ShippingGatewayInterface $shippingGateway
     */
    public function setShippingGateway(?ShippingGatewayInterface $shippingGateway): void;

    /**
     * @return \DateTime
     */
    public function getExportedAt(): ?\DateTime;

    /**
     * @param \DateTime $exportedAt
     */
    public function setExportedAt(?\DateTime $exportedAt): void;

    /**
     * @return string|null
     */
    public function getLabelPath(): ?string;

    /**
     * @param string|null $labelPath
     */
    public function setLabelPath(?string $labelPath): void;

    /**
     * @return string
     */
    public function getState(): ?string;

    /**
     * @param string $state
     */
    public function setState(?string $state): void;
}

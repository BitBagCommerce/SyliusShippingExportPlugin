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
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ShippingExportInterface extends ResourceInterface
{
    const STATE_NEW = 'new';
    const STATE_EXPORTED = 'exported';

    /**
     * @return ShipmentInterface
     */
    public function getShipment();

    /**
     * @param ShipmentInterface $shipment
     */
    public function setShipment(ShipmentInterface $shipment);

    /**
     * @return ShippingGatewayInterface
     */
    public function getShippingGateway();

    /**
     * @param ShippingGatewayInterface $shippingGateway
     */
    public function setShippingGateway(ShippingGatewayInterface $shippingGateway);

    /**
     * @return \DateTime
     */
    public function getExportedAt();

    /**
     * @param \DateTime $exportedAt
     */
    public function setExportedAt(\DateTime $exportedAt);

    /**
     * @return string|null
     */
    public function getLabelPath();

    /**
     * @param string|null $labelPath
     */
    public function setLabelPath($labelPath);

    /**
     * @return string
     */
    public function getState();

    /**
     * @param string $state
     */
    public function setState($state);
}
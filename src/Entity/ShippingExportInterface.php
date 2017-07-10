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
    const NEW_STATUS = 'new';
    const EXPORTED_STATUS = 'exported';
    const SHIPPED_STATUS = 'shipped';

    /**
     * @param ShipmentInterface $shipment
     */
    public function setShipment(ShipmentInterface $shipment);

    /**
     * @return ShipmentInterface
     */
    public function getShipment();

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date);

    /**
     * @return \DateTime
     */
    public function getDate();

    /**
     * @param string|null $label
     */
    public function setLabel($label);

    /**
     * @return string|null
     */
    public function getLabel();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();
}
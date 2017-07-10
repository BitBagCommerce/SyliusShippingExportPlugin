<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Factory;

use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ShippingExportFactoryInterface extends FactoryInterface
{
    /**
     * @param ShipmentInterface $shipment
     * @param \DateTime $date
     * @param string $status
     *
     * @return ShippingExportFactoryInterface
     */
    public function createWithShipmentAndStatusDate(ShipmentInterface $shipment, \DateTime $date, $status);
}
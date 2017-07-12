<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Factory;

use BitBag\ShippingExportPlugin\Entity\ShippingExportInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ShippingExportFactory implements ShippingExportFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function createWithShipmentAndStatusDate(ShipmentInterface $shipment, \DateTime $date, $status)
    {
        /** @var ShippingExportInterface $shippingExport */
        $shippingExport = $this->factory->createNew();

        $shippingExport->setShipment($shipment);
        $shippingExport->setDate($date);
        $shippingExport->setStatus($status);

        return $shippingExport;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return $this->factory->createNew();
    }
}
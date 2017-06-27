<?php

namespace BitBag\ShippingExportPlugin\Factory;

use BitBag\ShippingExportPlugin\Entity\ShippingExport;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class ShippingExportFactory implements FactoryInterface
{
    public function createWithShipmentAndStatusDate(ShipmentInterface $shipment, $status, $date)
    {
        $shippingExport = new ShippingExport();

        $shippingExport
            ->setShipment($shipment)
            ->setStatus($status)
            ->setDate($date)
        ;

        return $shippingExport;
    }

    /**
     * @return object
     */
    public function createNew()
    {
        return new ShippingExport();
    }
}
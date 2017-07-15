<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\ShippingExportPlugin\Behat\Mock\EventListener;

use BitBag\ShippingExportPlugin\Event\ExportShipmentEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrankMartinShippingExportEventListener
{
    /**
     * @var bool
     */
    private static $success = true;

    /**
     * @param ExportShipmentEvent $event
     */
    public function exportShipments(ExportShipmentEvent $event)
    {
        $shippingExport = $event->getShippingExport();
        $shippingGateway = $shippingExport->getShippingGateway();

        if ($shippingGateway->getCode() !== 'frank_martin_shipping_gateway') {
            return;
        }

        if(false === self::$success) {
            $event->addErrorFlash();

            return;
        }

        $event->addSuccessFlash();
        $event->exportShipment();
        $event->saveShippingLabel($this->mockLabelContent(), 'pdf');

    }

    /**
     * @param bool $toggle
     */
    public static function toggleSuccess($toggle)
    {
        self::$success = $toggle;
    }

    /**
     * @return bool|string
     */
    private function mockLabelContent()
    {
        return file_get_contents(__DIR__ . '/../../Resources/fixtures/frank_marting_a8d3w12.pdf');
    }
}
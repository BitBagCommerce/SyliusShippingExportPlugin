<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Mock\EventListener;

use BitBag\SyliusShippingExportPlugin\Event\ExportShipmentEvent;
use Webmozart\Assert\Assert;

final class FrankMartinShippingExportEventListener
{
    /** @var bool */
    private static $success = true;

    public function exportShipment(ExportShipmentEvent $event): void
    {
        $shippingExport = $event->getShippingExport();
        $shippingGateway = $shippingExport->getShippingGateway();

        if ($shippingGateway->getCode() !== 'frank_martin_shipping_gateway') {
            return;
        }

        if (false === self::$success) {
            $event->addErrorFlash();

            return;
        }

        $event->addSuccessFlash();
        $event->exportShipment();
        $event->saveShippingLabel($this->mockLabelContent(), 'pdf');
    }

    public static function toggleSuccess($toggle): void
    {
        self::$success = $toggle;
    }

    public function mockLabelContent(): string
    {
        $content = file_get_contents(__DIR__ . '/../../Resources/fixtures/frank_marting_a8d3w12.pdf');

        Assert::string($content);

        return $content;
    }
}

<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Event;

use BitBag\ShippingExportPlugin\Event\ExportShipmentEvent;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ExportShipmentEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExportShipmentEvent::class);
    }
}

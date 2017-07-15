<?php

namespace spec\BitBag\ShippingExportPlugin\EventListener;

use BitBag\ShippingExportPlugin\EventListener\PlacingShipmentForGatewayEventListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlacingShipmentForGatewayEventListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PlacingShipmentForGatewayEventListener::class);
    }
}

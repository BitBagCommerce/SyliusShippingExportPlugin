<?php

namespace spec\BitBag\ShippingExportPlugin\Model;

use BitBag\ShippingExportPlugin\Model\ShippingGateway;
use BitBag\ShippingExportPlugin\Model\ShippingGatewayInterface;
use PhpSpec\ObjectBehavior;

class ShippingGatewaySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingGateway::class);
    }

    function it_implements_shipping_gateway_interface()
    {
        $this->shouldImplement(ShippingGatewayInterface::class);
    }
}

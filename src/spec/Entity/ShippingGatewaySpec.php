<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Entity;

use BitBag\ShippingExportPlugin\Entity\ShippingGateway;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewaySpec extends ObjectBehavior
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

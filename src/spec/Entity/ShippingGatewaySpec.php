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
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewaySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingGateway::class);
    }

    function it_is_resource()
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_implements_shipping_gateway_interface()
    {
        $this->shouldImplement(ShippingGatewayInterface::class);
    }

    function it_returns_null_for_empty_shipping_method()
    {
        $this->getShippingMethod()->shouldReturn(null);
    }

    function it_sets_shipping_method(ShippingMethodInterface $shippingMethod)
    {
        $this->setShippingMethod($shippingMethod);
        $this->getShippingMethod()->shouldReturn($shippingMethod);
    }
}

<?php

declare(strict_types=1);
/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Exception;

use BitBag\ShippingExportPlugin\Exception\ShippingGatewayNotFoundException;
use PhpSpec\ObjectBehavior;

final class ShippingGatewayNotFoundExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Shipping gateway was not found.');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingGatewayNotFoundException::class);
    }

    function it_extends_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_has_a_message()
    {
        $this->getMessage()->shouldReturn('Shipping gateway was not found.');
    }
}

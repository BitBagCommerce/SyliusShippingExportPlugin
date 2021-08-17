<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\Exception;

use BitBag\SyliusShippingExportPlugin\Exception\ShippingGatewayNotFoundException;
use PhpSpec\ObjectBehavior;

final class ShippingGatewayNotFoundExceptionSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('Shipping gateway was not found.');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShippingGatewayNotFoundException::class);
    }

    function it_extends_exception(): void
    {
        $this->shouldHaveType(\Exception::class);
    }

    function it_has_a_message(): void
    {
        $this->getMessage()->shouldReturn('Shipping gateway was not found.');
    }
}

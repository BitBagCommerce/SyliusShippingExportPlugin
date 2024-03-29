<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\Entity;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGateway;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\Common\Collections\Collection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class ShippingGatewaySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShippingGateway::class);
    }

    function it_is_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_implements_shipping_gateway_interface(): void
    {
        $this->shouldImplement(ShippingGatewayInterface::class);
    }

    function it_returns_array_collection_when_initialized(): void
    {
        $this->getShippingMethods()->shouldHaveType(Collection::class);
    }

    function it_adds_shipping_method(ShippingMethodInterface $shippingMethod): void
    {
        $this->addShippingMethod($shippingMethod);

        $this->getShippingMethods()->first()->shouldReturn($shippingMethod);
    }

    function it_initializes_a_shipping_export_collection_by_default(): void
    {
        $this->getShippingExports()->shouldHaveType(Collection::class);
    }

    function it_adds_a_shipping_export(ShippingExportInterface $shippingExport): void
    {
        $this->addShippingExport($shippingExport);
        $this->hasShippingExport($shippingExport)->shouldReturn(true);
    }

    function it_removes_a_shipping_export(ShippingExportInterface $shippingExport): void
    {
        $this->addShippingExport($shippingExport);
        $this->removeShippingExport($shippingExport);

        $this->hasShippingExport($shippingExport)->shouldReturn(false);
    }

    function it_returns_config_value(): void
    {
        $this->setConfig(['foo' => 'bar']);

        $this->getConfigValue('foo')->shouldReturn('bar');
    }

    function it_throws_error_while_trying_to_access_not_existing_config_value(): void
    {
        $this->setConfig(['foo' => 'bar']);

        $this->shouldThrow(\InvalidArgumentException::class)->during('getConfigValue', ['bar']);
    }
}

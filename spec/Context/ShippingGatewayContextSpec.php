<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\Context;

use BitBag\SyliusShippingExportPlugin\Context\ShippingGatewayContext;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\SyliusShippingExportPlugin\Exception\ShippingGatewayNotFoundException;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class ShippingGatewayContextSpec extends ObjectBehavior
{
    function let(
        RequestStack $requestStack,
        FormTypeRegistryInterface $shippingGatewayFormTypeRegistry,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository
    ): void {
        $this->beConstructedWith(
            $requestStack,
            $shippingGatewayFormTypeRegistry,
            $shippingGatewayRepository,
            [
                'frank_martin_shipping_gateway' => 'Transporter Parcels',
            ]
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShippingGatewayContext::class);
    }

    function it_throws_exception_once_code_is_not_found(
        RequestStack $requestStack,
        Request $request,
        FormTypeRegistryInterface $shippingGatewayFormTypeRegistry
    ): void {
        $requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(null);
        $request->get('code')->willReturn('foo');

        $shippingGatewayFormTypeRegistry
            ->has('shipping_gateway_config', 'foo')
            ->willReturn(false);

        $this->shouldThrow(ShippingGatewayNotFoundException::class)->during('getCode');
    }

    function it_throws_exception_once_shipping_gateway_does_not_exist_in_database(
        RequestStack $requestStack,
        Request $request,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository
    ): void {
        $requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(1);
        $shippingGatewayRepository->find(1)->willReturn(null);

        $this->shouldThrow(ShippingGatewayNotFoundException::class)->during('getCode');
    }

    function it_returns_code_for_new_gateway(
        RequestStack $requestStack,
        Request $request,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        FormTypeRegistryInterface $shippingGatewayFormTypeRegistry
    ): void {
        $requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(null);
        $shippingGatewayRepository->find(null)->shouldNotBeCalled();
        $request->get('code')->willReturn('frank_martin_shipping_gateway');
        $shippingGatewayFormTypeRegistry
            ->has('shipping_gateway_config', 'frank_martin_shipping_gateway')
            ->willReturn(true);

        $this->getCode();
    }

    function it_returns_code_for_existing_gateway(
        RequestStack $requestStack,
        Request $request,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingGatewayInterface $shippingGateway
    ): void {
        $requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(1);
        $shippingGatewayRepository->find(1)->willReturn($shippingGateway);

        $this->getCode();
    }
}

<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Context;

use BitBag\ShippingExportPlugin\Context\ShippingGatewayContext;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\ShippingExportPlugin\Exception\ShippingGatewayNotFoundException;
use BitBag\ShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayContextSpec extends ObjectBehavior
{
    private $shippingGatewayFormTypeRegistry;

    private $shippingGatewayRepository;

    private $requestStack;

    function let(
        RequestStack $requestStack,
        FormTypeRegistryInterface $shippingGatewayFormTypeRegistry,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository
    )
    {

        $this->shippingGatewayFormTypeRegistry = $shippingGatewayFormTypeRegistry;
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->requestStack = $requestStack;

        $this->beConstructedWith(
            $requestStack,
            $shippingGatewayFormTypeRegistry,
            $shippingGatewayRepository,
            [
                'frank_martin_shipping_gateway' => "Transporter Parcels",
            ]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingGatewayContext::class);
    }

    function it_throws_exception_once_code_is_not_found(
        RequestStack $requestStack,
        Request $request,
        FormTypeRegistryInterface $formTypeRegistry
    )
    {
        $requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(null);
        $request->get('code')->willReturn('foo');

        $this->shippingGatewayFormTypeRegistry
            ->has('shipping_gateway_config', 'foo')
            ->willReturn(false)
        ;

        $this->shouldThrow(ShippingGatewayNotFoundException::class)->during('getCode');
    }

    function it_throws_exception_once_shipping_gateway_does_not_exist_in_database(Request $request)
    {
        $this->requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(1);
        $this->shippingGatewayRepository->find(1)->willReturn(null);

        $this->shouldThrow(ShippingGatewayNotFoundException::class)->during('getCode');
    }

    function it_returns_code_for_new_gateway(Request $request)
    {
        $this->requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(null);
        $this->shippingGatewayRepository->find(null)->shouldNotBeCalled();
        $request->get('code')->willReturn('frank_martin_shipping_gateway');
        $this->shippingGatewayFormTypeRegistry
            ->has('shipping_gateway_config', 'frank_martin_shipping_gateway')
            ->willReturn(true)
        ;

        $this->getCode();
    }

    function it_returns_code_for_existing_gateway(Request $request, ShippingGatewayInterface $shippingGateway)
    {
        $this->requestStack->getCurrentRequest()->willReturn($request);
        $request->get('id')->willReturn(1);
        $this->shippingGatewayRepository->find(1)->willReturn($shippingGateway);

        $this->getCode();
    }
}

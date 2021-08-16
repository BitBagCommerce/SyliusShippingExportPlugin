<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\EventListener;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\SyliusShippingExportPlugin\EventListener\PlacingShipmentForGatewayEventListener;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final class PlacingShipmentForGatewayEventListenerSpec extends ObjectBehavior
{
    function let(
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingExportRepositoryInterface $shippingExportRepository,
        FactoryInterface $shippingExportFactory
    ): void {
        $this->beConstructedWith($shippingGatewayRepository, $shippingExportRepository, $shippingExportFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PlacingShipmentForGatewayEventListener::class);
    }

    function it_prepares_shipping_export(
        GenericEvent $event,
        OrderInterface $order,
        ShipmentInterface $shipment,
        ShippingMethodInterface $shippingMethod,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingGatewayInterface $shippingGateway,
        FactoryInterface $shippingExportFactory,
        ShippingExportInterface $shippingExport,
        ShippingExportRepositoryInterface $shippingExportRepository
    ): void {
        $event->getSubject()->willReturn($order);
        $order->getShipments()->willReturn(new ArrayCollection([$shipment->getWrappedObject()]));
        $shipment->getMethod()->willReturn($shippingMethod);
        $shippingGatewayRepository->findOneByShippingMethod($shippingMethod)->willReturn($shippingGateway);
        $shippingExportFactory->createNew()->willReturn($shippingExport);

        $shippingExport->setShippingGateway($shippingGateway)->shouldBeCalled();
        $shippingExport->setShipment($shipment)->shouldBeCalled();
        $shippingExportRepository->add($shippingExport)->shouldBeCalled();

        $this->prepareShippingExport($event);
    }
}

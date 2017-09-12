<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\EventListener;

use BitBag\ShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\ShippingExportPlugin\EventListener\PlacingShipmentForGatewayEventListener;
use BitBag\ShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use BitBag\ShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PlacingShipmentForGatewayEventListenerSpec extends ObjectBehavior
{
    function let(
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingExportRepositoryInterface $shippingExportRepository,
        FactoryInterface $shippingExportFactory
    )
    {
        $this->beConstructedWith($shippingGatewayRepository, $shippingExportRepository, $shippingExportFactory);
    }

    function it_is_initializable()
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
    )
    {
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

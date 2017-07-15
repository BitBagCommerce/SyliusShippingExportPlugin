<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\EventListener;

use BitBag\ShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\ShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use BitBag\ShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PlacingShipmentForGatewayEventListener
{
    /**
     * @var ShippingGatewayRepositoryInterface
     */
    private $shippingGatewayRepository;

    /**
     * @var ShippingExportRepositoryInterface
     */
    private $shippingExportRepository;

    /**
     * @var FactoryInterface
     */
    private $shippingExportFactory;

    /**
     * @param ShippingGatewayRepositoryInterface $shippingGatewayRepository
     * @param ShippingExportRepositoryInterface $shippingExportRepository
     * @param FactoryInterface $shippingExportFactory
     */
    public function __construct(
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingExportRepositoryInterface $shippingExportRepository,
        FactoryInterface $shippingExportFactory
    )
    {
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->shippingExportRepository = $shippingExportRepository;
        $this->shippingExportFactory = $shippingExportFactory;
    }

    /**
     * @param GenericEvent $event
     */
    public function prepareShippingExport(GenericEvent $event)
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject();
        Assert::isInstanceOf($order, OrderInterface::class);

        $this->createShippingExportsForOrder($order);
    }

    /**
     * @param OrderInterface $order
     */
    private function createShippingExportsForOrder(OrderInterface $order)
    {
        if (0 === $order->getShipments()->count()) {
            return;
        }

        /** @var ShipmentInterface $shipment */
        foreach ($order->getShipments() as $shipment) {
            $shippingMethod = $shipment->getMethod();
            $shippingGateway = $this->shippingGatewayRepository->findOneByShippingMethod($shippingMethod);

            if($shippingGateway instanceof ShippingGatewayInterface) {
                $this->createNewShippingExportForShippingGatewayAndShipment($shippingGateway, $shipment);
            }
        }
    }

    /**
     * @param ShippingGatewayInterface $shippingGateway
     * @param ShipmentInterface $shipment
     */
    private function createNewShippingExportForShippingGatewayAndShipment(
        ShippingGatewayInterface $shippingGateway,
        ShipmentInterface $shipment
    )
    {
        /** @var ShippingExportInterface $shippingExport */
        $shippingExport = $this->shippingExportFactory->createNew();
        $shippingExport->setShippingGateway($shippingGateway);
        $shippingExport->setShipment($shipment);

        $this->shippingExportRepository->add($shippingExport);
    }
}
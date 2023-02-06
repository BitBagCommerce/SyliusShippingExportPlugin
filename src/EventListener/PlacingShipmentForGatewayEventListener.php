<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\EventListener;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class PlacingShipmentForGatewayEventListener
{
    private ShippingGatewayRepositoryInterface $shippingGatewayRepository;

    private ShippingExportRepositoryInterface $shippingExportRepository;

    private FactoryInterface $shippingExportFactory;

    public function __construct(
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingExportRepositoryInterface $shippingExportRepository,
        FactoryInterface $shippingExportFactory
    ) {
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->shippingExportRepository = $shippingExportRepository;
        $this->shippingExportFactory = $shippingExportFactory;
    }

    public function prepareShippingExport(GenericEvent $event): void
    {
        $order = $event->getSubject();
        Assert::isInstanceOf($order, OrderInterface::class);

        if (0 === count($order->getShipments())) {
            return;
        }

        /** @var ShipmentInterface $shipment */
        foreach ($order->getShipments() as $shipment) {
            $shippingMethod = $shipment->getMethod();
            Assert::notNull($shippingMethod);
            $shippingGateway = $this->shippingGatewayRepository->findOneByShippingMethod($shippingMethod);

            if ($shippingGateway instanceof ShippingGatewayInterface) {
                /** @var ShippingExportInterface $shippingExport */
                $shippingExport = $this->shippingExportFactory->createNew();
                $shippingExport->setShippingGateway($shippingGateway);
                $shippingExport->setShipment($shipment);

                $this->shippingExportRepository->add($shippingExport);
            }
        }
    }
}

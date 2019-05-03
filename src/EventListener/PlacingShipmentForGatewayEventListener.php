<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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
    /** @var ShippingGatewayRepositoryInterface */
    private $shippingGatewayRepository;

    /** @var ShippingExportRepositoryInterface */
    private $shippingExportRepository;

    /** @var FactoryInterface */
    private $shippingExportFactory;

    public function __construct(
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        ShippingExportRepositoryInterface $shippingExportRepository,
        FactoryInterface $shippingExportFactory
    ) {
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->shippingExportRepository = $shippingExportRepository;
        $this->shippingExportFactory = $shippingExportFactory;
    }

    public function prepareShippingExport(?GenericEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject();
        Assert::isInstanceOf($order, OrderInterface::class);

        if (0 === count($order->getShipments())) {
            return;
        }

        /** @var ShipmentInterface $shipment */
        foreach ($order->getShipments() as $shipment) {
            $shippingMethod = $shipment->getMethod();
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

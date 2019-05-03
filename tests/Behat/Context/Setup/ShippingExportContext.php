<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingExport;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethod;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ShipmentRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class ShippingExportContext implements Context
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var FactoryInterface */
    private $shipmentFactory;

    /** @var ShipmentRepositoryInterface */
    private $shipmentRepository;

    /** @var ShippingGatewayRepositoryInterface */
    private $shippingGatewayRepository;

    /** @var FactoryInterface */
    private $shippingExportFactory;

    /** @var ShippingExportRepositoryInterface */
    private $shippingExportRepository;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SharedStorageInterface $sharedStorage,
        FactoryInterface $shipmentFactory,
        ShipmentRepositoryInterface $shipmentRepository,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        FactoryInterface $shippingExportFactory,
        ShippingExportRepositoryInterface $shippingExportRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->orderRepository = $orderRepository;
        $this->sharedStorage = $sharedStorage;
        $this->shipmentFactory = $shipmentFactory;
        $this->shipmentRepository = $shipmentRepository;
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->shippingExportFactory = $shippingExportFactory;
        $this->shippingExportRepository = $shippingExportRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Given those orders were placed with :name shipping method
     */
    public function thoseOrdersWerePlacedWithShippingMethod(string $name): void
    {
        $orders = $this->orderRepository->findAll();
        /** @var ShippingMethod $shippingMethod */
        $shippingMethod = $this->sharedStorage->get('shipping_method');
        Assert::same($shippingMethod->getName(), $name);

        /** @var OrderInterface $order */
        foreach ($orders as $order) {
            /** @var ShipmentInterface $shipment */
            $shipment = $this->shipmentFactory->createNew();
            $shipment->setMethod($shippingMethod);
            $order->addShipment($shipment);

            $shippingGateway = $this->shippingGatewayRepository->findOneByShippingMethod($shippingMethod);

            if ($shippingGateway instanceof ShippingGatewayInterface) {
                $this->addShippingExportForGateway($shipment, $shippingGateway);
            }

            $this->shipmentRepository->add($shipment);
        }
    }

    /**
     * @Given those orders were completed
     */
    public function thoseOrdersWereCompleted(): void
    {
        $orders = $this->orderRepository->findAll();

        foreach ($orders as $order) {
            $this->eventDispatcher->dispatch('sylius.order.post_complete', new GenericEvent($order));
        }
    }

    /**
     * @Then :number new shipping exports should be created
     */
    public function newShippingExportsShouldBeCreated(string $number): void
    {
        Assert::eq(count($this->shippingExportRepository->findAll()), $number);
    }

    public function addShippingExportForGateway(ShipmentInterface $shipment, ShippingGatewayInterface $shippingGateway): void
    {
        /** @var ShippingExport $shippingExport */
        $shippingExport = $this->shippingExportFactory->createNew();
        $shippingExport->setShipment($shipment);
        $shippingExport->setShippingGateway($shippingGateway);

        $this->shippingExportRepository->add($shippingExport);
    }
}

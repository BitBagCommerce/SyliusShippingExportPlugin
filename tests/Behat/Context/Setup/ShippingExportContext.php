<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\ShippingExportPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\ShippingExportPlugin\Entity\ShippingExport;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\ShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use BitBag\ShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
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

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingExportContext implements Context
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var FactoryInterface
     */
    private $shipmentFactory;

    /**
     * @var ShipmentRepositoryInterface
     */
    private $shipmentRepository;

    /**
     * @var ShippingGatewayRepositoryInterface
     */
    private $shippingGatewayRepository;

    /**
     * @var FactoryInterface
     */
    private $shippingExportFactory;

    /**
     * @var ShippingExportRepositoryInterface
     */
    private $shippingExportRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $shipmentFactory
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param ShippingGatewayRepositoryInterface $shippingGatewayRepository
     * @param FactoryInterface $shippingExportFactory
     * @param ShippingExportRepositoryInterface $shippingExportRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SharedStorageInterface $sharedStorage,
        FactoryInterface $shipmentFactory,
        ShipmentRepositoryInterface $shipmentRepository,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        FactoryInterface $shippingExportFactory,
        ShippingExportRepositoryInterface $shippingExportRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
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
    public function thoseOrdersWerePlacedWithShippingMethod($name)
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
     * @param ShipmentInterface $shipment
     * @param ShippingGatewayInterface $shippingGateway
     */
    private function addShippingExportForGateway(ShipmentInterface $shipment, ShippingGatewayInterface $shippingGateway)
    {
        /** @var ShippingExport $shippingExport */
        $shippingExport = $this->shippingExportFactory->createNew();
        $shippingExport->setShipment($shipment);
        $shippingExport->setShippingGateway($shippingGateway);

        $this->shippingExportRepository->add($shippingExport);
    }

    /**
     * @Given those orders were completed
     */
    public function thoseOrdersWereCompleted()
    {
        $orders = $this->orderRepository->findAll();

        foreach ($orders as $order) {
            $this->eventDispatcher->dispatch('sylius.order.post_complete', new GenericEvent($order));
        }
    }

    /**
     * @Then :number new shipping exports should be created
     */
    public function newShippingExportsShouldBeCreated($number)
    {
        Assert::eq(count($this->shippingExportRepository->findAll()), $number);
    }
}

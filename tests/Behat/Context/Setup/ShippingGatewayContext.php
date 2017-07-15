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
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayContext implements Context
{
    /**
     * @var FactoryInterface
     */
    private $shippingMethodFactory;

    /**
     * @var FactoryInterface
     */
    private $shippingGatewayFactory;

    /**
     * @var RepositoryInterface
     */
    private $shippingMethodRepository;

    /**
     * @var RepositoryInterface
     */
    private $shippingGatewayRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @param FactoryInterface $shippingMethodFactory
     * @param FactoryInterface $shippingGatewayFactory
     * @param RepositoryInterface $shippingMethodRepository
     * @param RepositoryInterface $shippingGatewayRepository
     * @param EntityManagerInterface $entityManager
     * @param SharedStorageInterface $sharedStorage
     * @internal param ObjectManager $objectManager
     */
    public function __construct(
        FactoryInterface $shippingMethodFactory,
        FactoryInterface $shippingGatewayFactory,
        RepositoryInterface $shippingMethodRepository,
        RepositoryInterface $shippingGatewayRepository,
        EntityManagerInterface $entityManager,
        SharedStorageInterface $sharedStorage
    )
    {
        $this->shippingMethodFactory = $shippingMethodFactory;
        $this->shippingGatewayFactory = $shippingGatewayFactory;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->entityManager = $entityManager;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Given there is a shipping method named :name with :code code
     */
    public function thereIsAShippingMethodNamedWithCode($name, $code)
    {
        /** @var ShippingMethodInterface $shippingMethod */
        $shippingMethod = $this->shippingMethodFactory->createNew();
        $shippingMethod->setName($name);
        $shippingMethod->setCode($code);

        $this->sharedStorage->set('shipping_method', $shippingMethod);
        $this->shippingMethodRepository->add($shippingMethod);
    }

    /**
     * @Given there is a registered shipping gateway for this shipping method
     */
    public function thereIsARegisteredShippingGatewayForThisShippingMethod()
    {
        /** @var ShippingGatewayInterface $shippingGateway */
        $shippingGateway = $this->shippingGatewayFactory->createNew();
        /** @var ShippingMethodInterface $shippingMethod */
        $shippingMethod = $this->sharedStorage->get('shipping_method');

        $shippingGateway->setShippingMethod($shippingMethod);

        $this->sharedStorage->set('shipping_gateway', $shippingGateway);
    }

    /**
     * @Given this shipping gateway has :code code and :label label
     */
    public function thisShippingGatewayHasCodeAndLabel($code, $label)
    {
        /** @var ShippingGatewayInterface $shippingGateway */
        $shippingGateway = $this->sharedStorage->get('shipping_gateway');

        $shippingGateway->setCode($code);
        $shippingGateway->setLabel($label);

        $this->sharedStorage->set('shipping_gateway', $shippingGateway);
        $this->shippingGatewayRepository->add($shippingGateway);
    }

    /**
     * @Given it has :field field set to :value
     */
    public function itHasFieldSetTo($field, $value)
    {
        /** @var ShippingGatewayInterface $shippingGateway */
        $shippingGateway = $this->sharedStorage->get('shipping_gateway');

        $this->config[$field] = $value;
        $shippingGateway->setConfig($this->config);

        $this->sharedStorage->set('shipping_gateway', $shippingGateway);
    }
}

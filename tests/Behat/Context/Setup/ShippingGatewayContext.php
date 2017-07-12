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

        $this->shippingMethodRepository->add($shippingMethod);
        $this->sharedStorage->set('shipping_method', $shippingMethod);
    }

    /**
     * @Given I am able to create a shipping gateway with :name name and :code code
     */
    public function iAmAbleToCreateAShippingGatewayWithNameForThisShippingMethod($name, $code)
    {
        /** @var ShippingGatewayInterface $shippingGateway */
        $shippingGateway = $this->shippingGatewayFactory->createNew();

        $shippingGateway->setName($name);
        $shippingGateway->setCode($code);

        $this->shippingGatewayRepository->add($shippingGateway);
        $this->sharedStorage->set('shipping_gateway', $shippingGateway);
    }

    /**
     * @Given :fields fields can be configured for this gateway
     */
    public function fieldsCanBeConfiguredForThisGateway(...$fields)
    {
        $shippingGateway = $this->sharedStorage->get('shipping_gateway');
        $shippingGateway->setConfiguration($fields);

        $this->sharedStorage->set('shipping_gateway', $shippingGateway);
        $this->entityManager->flush($shippingGateway);
    }
}

<?php

namespace Tests\BitBag\ShippingExportPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

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
     * @var ShippingGatewayInterface
     */
    private $shippingGateway;

    /**
     * ShippingGatewayContext constructor.
     * @param FactoryInterface $shippingMethodFactory
     * @param FactoryInterface $shippingGatewayFactory
     */
    public function __construct(
        FactoryInterface $shippingMethodFactory,
        FactoryInterface $shippingGatewayFactory
    )
    {
        $this->shippingMethodFactory = $shippingMethodFactory;
        $this->shippingGatewayFactory = $shippingGatewayFactory;
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
    }

    /**
     * @Given I am able to create a shipping gateway with :name name and :code code for this shipping method
     */
    public function iAmAbleToCreateAShippingGatewayWithNameForThisShippingMethod($name, $code)
    {
        $shippingGateway = $this->shippingGatewayFactory->createNew();
        $shippingGateway->setName($name);
        $shippingGateway->setCode($code);
        $this->shippingGateway = $shippingGateway;
    }

    /**
     * @Given :fields fields can be configured for this gateway
     */
    public function fieldsCanBeConfiguredForThisGateway($fields)
    {
        $fields = explode(",", $fields);
        $this->shippingGateway->setConfiguration($fields);
    }
}

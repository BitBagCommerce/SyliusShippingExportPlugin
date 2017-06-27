<?php

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;

class ShippingGateway implements ShippingGatewayInterface
{
    use TranslatableTrait  {
        __construct as private initializeTranslationsCollection;
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ShippingMethodInterface
     */
    private $shippingMethod;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return ShippingGateway
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return ShippingMethodInterface
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param ShippingMethodInterface $shippingMethod
     *
     * @return ShippingGateway
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param array $configuration
     *
     * @return ShippingGateway
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return ShippingGatewayTranslation
     */
    protected function createTranslation()
    {
        return new ShippingGatewayTranslation();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ShippingGateway
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}

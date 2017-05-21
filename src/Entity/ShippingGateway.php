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
     * @var ShippingMethodInterface
     */
    private $shippingMethod;

    /**
     * @var array
     */
    private $configuration;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod)
    {
        return $this->shippingMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $config)
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation()
    {
        return new ShippingGatewayTranslation();
    }
}

<?php

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface ShippingGatewayInterface extends ResourceInterface, TranslatableInterface
{
    /**
     * @param string $code
     */
    public function setCode($code);

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param ShippingMethodInterface $shippingMethod
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod);

    /**
     * @param array $config
     */
    public function setConfiguration(array $config);
}
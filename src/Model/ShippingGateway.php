<?php

namespace BitBag\ShippingExportPlugin\Model;

use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class ShippingGateway implements ShippingGatewayInterface
{
    use TranslatableTrait;

    /**
     * @return mixed
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        // TODO: Implement setCode() method.
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        // TODO: Implement setName() method.
    }

    /**
     * @param ShippingMethodInterface $shippingMethod
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod)
    {
        // TODO: Implement setShippingMethod() method.
    }

    /**
     * @param array $config
     */
    public function setConfiguration(array $config)
    {
        // TODO: Implement setConfiguration() method.
    }

    /**
     * Create resource translation model.
     *
     * @return TranslationInterface
     */
    protected function createTranslation()
    {
        // TODO: Implement createTranslation() method.
    }
}

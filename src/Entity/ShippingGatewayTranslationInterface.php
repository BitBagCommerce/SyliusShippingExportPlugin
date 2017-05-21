<?php

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ShippingGatewayTranslationInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);
}

<?php

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;

class ShippingGatewayTranslation extends AbstractTranslation implements ShippingGatewayTranslationInterface
{
    private $id;

    private $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}

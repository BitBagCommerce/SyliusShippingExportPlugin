<?php

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ShippingExportInterface extends ResourceInterface
{
    const NEW_STATUS = 'new';

    const EXPORTED_STATUS = 'exported';

    const SHIPPED_STATUS = 'shipped';

    /**
     * @return ShipmentInterface
     */
    public function getShipment();

    /**
     * @return \DateTime
     */
    public function getDate();

    /**
     * @return string|null
     */
    public function getLabel();

    /**
     * @return ShippingExportInterface
     */
    public function getStatus();
}
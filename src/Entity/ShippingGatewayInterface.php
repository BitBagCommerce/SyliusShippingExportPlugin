<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ShippingGatewayInterface extends ResourceInterface
{
    /**
     * @param string $code
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $label
     */
    public function setLabel($label);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param ShippingMethodInterface $shippingMethod
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod);

    /**
     * @return ShippingMethodInterface
     */
    public function getShippingMethod();

    /**
     * @param array $config
     */
    public function setConfig(array $config);

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function addShippingExport(ShippingExportInterface $shippingExport);

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function removeShippingExport(ShippingExportInterface $shippingExport);

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function hasShippingExport(ShippingExportInterface $shippingExport);
}
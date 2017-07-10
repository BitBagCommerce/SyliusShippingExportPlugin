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
use Sylius\Component\Resource\Model\TranslatableInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
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
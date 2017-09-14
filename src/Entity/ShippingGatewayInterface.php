<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\ShippingExportPlugin\Entity;

use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ShippingGatewayInterface extends ResourceInterface
{
    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void;

    /**
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @param string|null $label
     */
    public function setLabel(?string $label): void;

    /**
     * @return string|null
     */
    public function getLabel(): ?string;

    /**
     * @param ShippingMethodInterface $shippingMethod
     */
    public function setShippingMethod(?ShippingMethodInterface $shippingMethod): void;

    /**
     * @return ShippingMethodInterface
     */
    public function getShippingMethod(): ?ShippingMethodInterface;

    /**
     * @param array|null $config
     */
    public function setConfig(?array $config): void;

    /**
     * @return array|null
     */
    public function getConfig(): ?array;

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function addShippingExport(?ShippingExportInterface $shippingExport): void;

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function removeShippingExport(?ShippingExportInterface $shippingExport): void;

    /**
     * @param ShippingExportInterface $shippingExport
     *
     * @return bool
     */
    public function hasShippingExport(?ShippingExportInterface $shippingExport): bool;

    /**
     * @param string|null $key
     *
     * @return string|null
     */
    public function getConfigValue(?string $key): ?string;
}
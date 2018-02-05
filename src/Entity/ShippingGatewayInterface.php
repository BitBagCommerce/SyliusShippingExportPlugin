<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

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
     * @param array|null $config
     */
    public function setConfig(?array $config): void;

    /**
     * @return array|null
     */
    public function getConfig(): ?array;

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getConfigValue(string $key): ?string;

    /**
     * @return Collection|null
     */
    public function getShippingMethods(): ?Collection;

    /**
     * @param ShippingMethodInterface $shippingMethod
     */
    public function addShippingMethod(ShippingMethodInterface $shippingMethod): void;

    /**
     * @param ShippingMethodInterface $shippingMethod
     */
    public function removeShippingMethod(ShippingMethodInterface $shippingMethod): void;

    /**
     * @param ShippingMethodInterface $shippingMethod
     *
     * @return bool
     */
    public function hasShippingMethod(ShippingMethodInterface $shippingMethod): bool;

    /**
     * @return Collection|null
     */
    public function getShippingExports(): ?Collection;

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function addShippingExport(ShippingExportInterface $shippingExport): void;

    /**
     * @param ShippingExportInterface $shippingExport
     */
    public function removeShippingExport(ShippingExportInterface $shippingExport): void;

    /**
     * @param ShippingExportInterface $shippingExport
     *
     * @return bool
     */
    public function hasShippingExport(ShippingExportInterface $shippingExport): bool;
}

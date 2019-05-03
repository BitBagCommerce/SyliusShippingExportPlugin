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
    public function setCode(?string $code): void;

    public function getCode(): ?string;

    public function setName(?string $name): void;

    public function getName(): ?string;

    public function setConfig(?array $config): void;

    public function getConfig(): ?array;

    public function getConfigValue(string $key);

    public function getShippingMethods(): ?Collection;

    public function addShippingMethod(ShippingMethodInterface $shippingMethod): void;

    public function removeShippingMethod(ShippingMethodInterface $shippingMethod): void;

    public function hasShippingMethod(ShippingMethodInterface $shippingMethod): bool;

    public function getShippingExports(): ?Collection;

    public function addShippingExport(ShippingExportInterface $shippingExport): void;

    public function removeShippingExport(ShippingExportInterface $shippingExport): void;

    public function hasShippingExport(ShippingExportInterface $shippingExport): bool;
}

<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

    public function setConfig(array $config): void;

    public function getConfig(): array;

    /** @return mixed */
    public function getConfigValue(string $key);

    /** @return Collection<int, ShippingMethodInterface> */
    public function getShippingMethods(): ?Collection;

    public function addShippingMethod(ShippingMethodInterface $shippingMethod): void;

    public function removeShippingMethod(ShippingMethodInterface $shippingMethod): void;

    public function hasShippingMethod(ShippingMethodInterface $shippingMethod): bool;

    /** @return Collection<int, ShippingExportInterface>|ShippingExportInterface[] */
    public function getShippingExports(): ?Collection;

    public function addShippingExport(ShippingExportInterface $shippingExport): void;

    public function removeShippingExport(ShippingExportInterface $shippingExport): void;

    public function hasShippingExport(ShippingExportInterface $shippingExport): bool;
}

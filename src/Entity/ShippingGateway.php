<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

class ShippingGateway implements ShippingGatewayInterface
{
    /** @var int */
    protected $id;

    /** @var string|null */
    protected $code;

    /** @var string|null */
    protected $name;

    /** @var array */
    protected $config = [];

    /** @var Collection<int, ShippingMethodInterface>|ShippingMethodInterface[] */
    protected $shippingMethods;

    /** @var Collection<int, ShippingExportInterface>|ShippingExportInterface[] */
    protected $shippingExports;

    public function __construct()
    {
        $this->shippingExports = new ArrayCollection();
        $this->shippingMethods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getConfigValue(string $key)
    {
        Assert::keyExists($this->config, $key, sprintf(
            'Shipping gateway config named %s does not exist.',
            $key,
        ));

        return $this->config[$key];
    }

    public function getShippingMethods(): ?Collection
    {
        return $this->shippingMethods;
    }

    public function addShippingMethod(ShippingMethodInterface $shippingMethod): void
    {
        if (!$this->hasShippingMethod($shippingMethod)) {
            $this->shippingMethods->add($shippingMethod);
        }
    }

    public function removeShippingMethod(ShippingMethodInterface $shippingMethod): void
    {
        if ($this->hasShippingMethod($shippingMethod)) {
            $this->shippingMethods->removeElement($shippingMethod);
        }
    }

    public function hasShippingMethod(ShippingMethodInterface $shippingMethod): bool
    {
        return $this->shippingMethods->contains($shippingMethod);
    }

    public function getShippingExports(): ?Collection
    {
        return $this->shippingExports;
    }

    public function addShippingExport(ShippingExportInterface $shippingExport): void
    {
        if (!$this->hasShippingExport($shippingExport)) {
            $this->shippingExports->add($shippingExport);
            $shippingExport->setShippingGateway($this);
        }
    }

    public function removeShippingExport(ShippingExportInterface $shippingExport): void
    {
        if ($this->hasShippingExport($shippingExport)) {
            $this->shippingExports->removeElement($shippingExport);
        }
    }

    public function hasShippingExport(ShippingExportInterface $shippingExport): bool
    {
        return $this->shippingExports->contains($shippingExport);
    }
}

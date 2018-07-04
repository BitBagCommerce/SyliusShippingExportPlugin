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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

class ShippingGateway implements ShippingGatewayInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Collection|ShippingMethodInterface[]
     */
    protected $shippingMethods;

    /**
     * @var Collection|ShippingExportInterface[]
     */
    protected $shippingExports;

    public function __construct()
    {
        $this->shippingExports = new ArrayCollection();
        $this->shippingMethods = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(?array $config): void
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigValue(string $key)
    {
        Assert::keyExists($this->config, $key, sprintf(
            'Shipping gateway config named %s does not exist.',
            $key
        ));

        return $this->config[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethods(): ?Collection
    {
        return $this->shippingMethods;
    }

    /**
     * {@inheritdoc}
     */
    public function addShippingMethod(ShippingMethodInterface $shippingMethod): void
    {
        if (!$this->hasShippingMethod($shippingMethod)) {
            $this->shippingMethods->add($shippingMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeShippingMethod(ShippingMethodInterface $shippingMethod): void
    {
        if ($this->hasShippingMethod($shippingMethod)) {
            $this->shippingMethods->removeElement($shippingMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasShippingMethod(ShippingMethodInterface $shippingMethod): bool
    {
        return $this->shippingMethods->contains($shippingMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingExports(): ?Collection
    {
        return $this->shippingExports;
    }

    /**
     * {@inheritdoc}
     */
    public function addShippingExport(ShippingExportInterface $shippingExport): void
    {
        if (!$this->hasShippingExport($shippingExport)) {
            $this->shippingExports->add($shippingExport);
            $shippingExport->setShippingGateway($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeShippingExport(ShippingExportInterface $shippingExport): void
    {
        if ($this->hasShippingExport($shippingExport)) {
            $this->shippingExports->removeElement($shippingExport);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasShippingExport(ShippingExportInterface $shippingExport): bool
    {
        return $this->shippingExports->contains($shippingExport);
    }
}

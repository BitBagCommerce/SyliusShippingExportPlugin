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

use BitBag\ShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
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
    protected $label;

    /**
     * @var ShippingMethodInterface
     */
    protected $shippingMethod;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Collection|ShippingExportInterface[]
     */
    protected $shippingExports;

    public function __construct()
    {
        $this->shippingExports = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
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
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingMethod(?ShippingMethodInterface $shippingMethod): void
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethod(): ?ShippingMethodInterface
    {
        return $this->shippingMethod;
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
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingExports(): ?ArrayCollection
    {
        return $this->shippingExports;
    }

    /**
     * {@inheritdoc}
     */
    public function addShippingExport(?ShippingExportInterface $shippingExport): void
    {
        if (!$this->hasShippingExport($shippingExport)) {
            $this->shippingExports->add($shippingExport);
            $shippingExport->setShippingGateway($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeShippingExport(?ShippingExportInterface $shippingExport): void
    {
        if ($this->hasShippingExport($shippingExport)) {
            $this->shippingExports->removeElement($shippingExport);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasShippingExport(?ShippingExportInterface $shippingExport): ?ShippingExportInterface
    {
        return $this->shippingExports->contains($shippingExport);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigValue(?string $key): ?string
    {
        Assert::keyExists($this->config, $key, sprintf(
            "Shipping gateway config named %s does not exist.",
            $key
        ));

        return $this->config[$key];
    }
}

<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Entity;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingMethod(ShippingMethodInterface $shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingExports()
    {
        return $this->shippingExports;
    }

    /**
     * {@inheritdoc}
     */
    public function addShippingExport(ShippingExportInterface $shippingExport)
    {
        if (!$this->hasShippingExport($shippingExport)) {
            $this->shippingExports->add($shippingExport);
            $shippingExport->setShippingGateway($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeShippingExport(ShippingExportInterface $shippingExport)
    {
        if ($this->hasShippingExport($shippingExport)) {
            $this->shippingExports->removeElement($shippingExport);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasShippingExport(ShippingExportInterface $shippingExport)
    {
        return $this->shippingExports->contains($shippingExport);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigValue($key)
    {
        Assert::keyExists($this->config, $key, "Shipping gateway config does not exist.");

        return $this->config[$key];
    }
}

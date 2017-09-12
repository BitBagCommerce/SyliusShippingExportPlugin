<?php

declare(strict_types=1);

use Sylius\Bundle\CoreBundle\Application\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

final class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): array
    {
        return array_merge(parent::registerBundles(), [
            new \Sylius\Bundle\AdminBundle\SyliusAdminBundle(),
            new \Sylius\Bundle\ShopBundle\SyliusShopBundle(),

            new \FOS\OAuthServerBundle\FOSOAuthServerBundle(), // Required by SyliusApiBundle
            new \Sylius\Bundle\AdminApiBundle\SyliusAdminApiBundle(),

            new \BitBag\ShippingExportPlugin\ShippingExportPlugin(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader): string
    {
        $loader->load($this->getRootDir() . '/config/config.yml');
    }
}

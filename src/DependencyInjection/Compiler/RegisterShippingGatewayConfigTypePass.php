<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\ShippingExportPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class RegisterShippingGatewayConfigTypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('bitbag.form_registry.shipping_gateway_config')) {
            return;
        }

        $formRegistry = $container->findDefinition('bitbag.form_registry.shipping_gateway_config');
        $gatewayFactories = [];

        $gatewayConfigurationTypes = $container->findTaggedServiceIds('bitbag.shipping_gateway_configuration_type');

        foreach ($gatewayConfigurationTypes as $id => $attributes) {
            if (!isset($attributes[0]['type']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged shipping gateway configuration type needs to have `type` and `label` attributes.');
            }

            $gatewayFactories[$attributes[0]['type']] = $attributes[0]['label'];

            $formRegistry->addMethodCall(
                'add',
                ['shipping_gateway_config', $attributes[0]['type'], $container->getDefinition($id)->getClass()]
            );
        }

        $container->setParameter('bitbag.shipping_gateways', $gatewayFactories);
    }
}

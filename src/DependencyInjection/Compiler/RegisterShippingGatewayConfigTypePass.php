<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterShippingGatewayConfigTypePass implements CompilerPassInterface
{
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

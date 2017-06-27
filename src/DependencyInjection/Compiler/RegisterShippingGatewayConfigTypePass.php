<?php

namespace BitBag\ShippingExportPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterShippingGatewayConfigTypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('bitbag.form_registry.shipping_gateway_config')) {
            return;
        }

        $formRegistry = $container->findDefinition('bitbag.form_registry.shipping_gateway_config');
        $gatewayFactories = [];

        $gatewayConfigurationTypes = $container->findTaggedServiceIds('bitbag.shipping_gateway_configuration_type');

        foreach ($gatewayConfigurationTypes as $id => $attributes) {
            if (!isset($attributes[0]['type']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged gateway configuration type needs to have `type` and `label` attributes.');
            }

            $gatewayFactories[$attributes[0]['type']] = $attributes[0]['label'];

            $formRegistry->addMethodCall(
                'add',
                ['shipping_gateway_config', $attributes[0]['type'], $container->getDefinition($id)->getClass()]
            );
        }

        $container->setParameter('bitbag.shipping_gateway_factories', $gatewayFactories);
    }
}

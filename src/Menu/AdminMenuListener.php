<?php

namespace BitBag\ShippingExportPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function configureShippingGatewayMenu(MenuBuilderEvent $event)
    {
        $event
            ->getMenu()
            ->getChild('configuration')
            ->addChild('shipping_gateway', ['route' => 'bitbag_admin_shipping_gateway_index'])
            ->setLabel('bitbag.shipping_export_plugin.menu.admin.shipping_gateway')
        ;
    }
}
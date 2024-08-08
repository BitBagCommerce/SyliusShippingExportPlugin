<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ShippingGatewayMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        /** @var ItemInterface $configurationItem */
        $configurationItem = $menu->getChild('configuration');

        $configurationItem
            ->addChild('shipping_gateways', ['route' => 'bitbag_admin_shipping_gateway_index'])
            ->setLabel('bitbag.ui.shipping_gateways')
            ->setLabelAttribute('icon', 'cloud')
        ;
    }
}

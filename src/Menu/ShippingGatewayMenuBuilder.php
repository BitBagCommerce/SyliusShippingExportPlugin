<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ShippingGatewayMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $event): void
    {
        $event
            ->getMenu()
            ->getChild('configuration')
            ->addChild('shipping_gateways', ['route' => 'bitbag_admin_shipping_gateway_index'])
            ->setLabel('bitbag.ui.shipping_gateways')
            ->setLabelAttribute('icon', 'cloud')
        ;
    }
}

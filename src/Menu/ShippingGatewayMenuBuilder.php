<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\ShippingExportPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayMenuBuilder
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function buildMenu(?MenuBuilderEvent $event): void
    {
        $event
            ->getMenu()
            ->getChild('configuration')
            ->addChild('shipping_gateway', ['route' => 'bitbag_admin_shipping_gateway_index'])
            ->setLabel('bitbag.ui.shipping_gateways')
            ->setLabelAttribute('icon', 'cloud')
        ;
    }
}
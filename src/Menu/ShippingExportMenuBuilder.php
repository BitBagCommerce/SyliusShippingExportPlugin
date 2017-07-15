<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingExportMenuBuilder
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function buildMenu(MenuBuilderEvent $event)
    {
        $event
            ->getMenu()
            ->getChild('sales')
            ->addChild('shipping_export', ['route' => 'bitbag_admin_shipping_export_index'])
            ->setLabel('bitbag.ui.export_shipments')
            ->setLabelAttribute('icon', 'arrow up')
        ;
    }
}
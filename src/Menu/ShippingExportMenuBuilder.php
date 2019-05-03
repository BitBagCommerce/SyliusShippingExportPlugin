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

final class ShippingExportMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $event): void
    {
        $event
            ->getMenu()
            ->getChild('sales')
            ->addChild('shipping_exports', ['route' => 'bitbag_admin_shipping_export_index'])
            ->setName('bitbag.ui.export_shipments')
            ->setLabelAttribute('icon', 'arrow up')
        ;
    }
}

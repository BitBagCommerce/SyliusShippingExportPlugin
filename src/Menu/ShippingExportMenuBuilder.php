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

final class ShippingExportMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        /** @var ItemInterface $salesMenu */
        $salesMenu = $menu->getChild('sales');

        $salesMenu->addChild('shipping_exports', ['route' => 'bitbag_admin_shipping_export_index'])
            ->setName('bitbag.ui.export_shipments')
            ->setLabelAttribute('icon', 'arrow up')
        ;
    }
}

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

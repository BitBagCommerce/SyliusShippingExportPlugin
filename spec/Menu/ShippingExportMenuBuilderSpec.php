<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\Menu;

use BitBag\SyliusShippingExportPlugin\Menu\ShippingExportMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ShippingExportMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShippingExportMenuBuilder::class);
    }

    function it_builds_menu(
        MenuBuilderEvent $event,
        ItemInterface $rootMenuItem,
        ItemInterface $configurationItem,
        ItemInterface $shippingGatewayMenuItem
    ): void {
        $event->getMenu()->willReturn($rootMenuItem);
        $rootMenuItem->getChild('sales')->willReturn($configurationItem);
        $configurationItem
            ->addChild('shipping_exports', ['route' => 'bitbag_admin_shipping_export_index'])
            ->willReturn($shippingGatewayMenuItem)
        ;
        $shippingGatewayMenuItem->setName('bitbag.ui.export_shipments')->willReturn($shippingGatewayMenuItem);
        $shippingGatewayMenuItem->setLabelAttribute('icon', 'arrow up')->shouldBeCalled();

        $this->buildMenu($event);
    }
}

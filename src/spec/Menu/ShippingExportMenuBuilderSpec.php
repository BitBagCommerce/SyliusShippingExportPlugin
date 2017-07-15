<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Menu;

use BitBag\ShippingExportPlugin\Menu\ShippingExportMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingExportMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingExportMenuBuilder::class);
    }

    function it_builds_menu(
        MenuBuilderEvent $event,
        ItemInterface $rootMenuItem,
        ItemInterface $configurationItem,
        ItemInterface $shippingGatewayMenuItem
    )
    {
        $event->getMenu()->willReturn($rootMenuItem);
        $rootMenuItem->getChild('sales')->willReturn($configurationItem);
        $configurationItem
            ->addChild('shipping_export', ['route' => 'bitbag_admin_shipping_export_index'])
            ->willReturn($shippingGatewayMenuItem)
        ;
        $shippingGatewayMenuItem->setLabel('bitbag.ui.export_shipments')->willReturn($shippingGatewayMenuItem);
        $shippingGatewayMenuItem->setLabelAttribute('icon', 'arrow up')->shouldBeCalled();

        $this->buildMenu($event);
    }
}
<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Menu;

use BitBag\ShippingExportPlugin\Menu\ShippingGatewayMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingGatewayMenuBuilder::class);
    }

    function it_builds_menu(
        MenuBuilderEvent $event,
        ItemInterface $rootMenuItem,
        ItemInterface $configurationItem,
        ItemInterface $shippingGatewayMenuItem
    )
    {
        $event->getMenu()->willReturn($rootMenuItem);
        $rootMenuItem->getChild('configuration')->willReturn($configurationItem);
        $configurationItem
            ->addChild('shipping_gateway', ['route' => 'bitbag_admin_shipping_gateway_index'])
            ->willReturn($shippingGatewayMenuItem)
        ;
        $shippingGatewayMenuItem->setLabel('bitbag.ui.shipping_gateways')->willReturn($shippingGatewayMenuItem);
        $shippingGatewayMenuItem->setLabelAttribute('icon', 'cloud')->shouldBeCalled();

        $this->buildMenu($event);
    }
}
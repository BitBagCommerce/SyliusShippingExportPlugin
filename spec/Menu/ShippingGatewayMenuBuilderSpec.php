<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\Menu;

use BitBag\SyliusShippingExportPlugin\Menu\ShippingGatewayMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ShippingGatewayMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShippingGatewayMenuBuilder::class);
    }

    function it_builds_menu(
        MenuBuilderEvent $event,
        ItemInterface $rootMenuItem,
        ItemInterface $configurationItem,
        ItemInterface $shippingGatewayMenuItem
    ): void {
        $event->getMenu()->willReturn($rootMenuItem);
        $rootMenuItem->getChild('configuration')->willReturn($configurationItem);
        $configurationItem
            ->addChild('shipping_gateways', ['route' => 'bitbag_admin_shipping_gateway_index'])
            ->willReturn($shippingGatewayMenuItem)
        ;
        $shippingGatewayMenuItem->setLabel('bitbag.ui.shipping_gateways')->willReturn($shippingGatewayMenuItem);
        $shippingGatewayMenuItem->setLabelAttribute('icon', 'cloud')->shouldBeCalled();

        $this->buildMenu($event);
    }
}

<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\EventListener\Grid;

use Sylius\Component\Grid\Event\GridDefinitionConverterEvent;

final class AdminShippingGatewayGridEventListener
{
    /** @var array */
    private $shippingGateways;

    public function __construct(array $shippingGateways)
    {
        $this->shippingGateways = $shippingGateways;
    }

    public function editActionLinks(GridDefinitionConverterEvent $event): void
    {
        $grid = $event->getGrid();

        $actions = $grid->getActions('main');
        if (!isset($actions['create'])) {
            return;
        }
        $createAction = $actions['create'];
        $options = $createAction->getOptions();

        foreach ($this->shippingGateways as $shippingGatewayType => $shippingGatewayLabel) {
            $options['links'][$shippingGatewayType] = [
                'label' => $shippingGatewayLabel,
                'icon' => 'tabler:plus',
                'route' => 'bitbag_admin_shipping_gateway_create',
                'parameters' => [
                    'code' => $shippingGatewayType,
                ],
            ];
        }

        $createAction->setOptions($options);
    }
}

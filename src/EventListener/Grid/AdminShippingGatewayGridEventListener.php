<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
                'icon' => 'plus',
                'route' => 'bitbag_admin_shipping_gateway_create',
                'parameters' => [
                    'code' => $shippingGatewayType,
                ],
            ];
        }

        $createAction->setOptions($options);
    }
}

<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingExport;

use Behat\Mink\Element\ElementInterface;
use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;

final class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    public function getShipmentsWithState(string $state): array
    {
        $items = $this->getDocument()->findAll('css', '.shipping-export-state');
        $result = [];

        /** @var ElementInterface $item */
        foreach ($items as $item) {
            if ($item->getText() === $state) {
                $result[] = $item;
            }
        }

        return $result;
    }

    public function exportAllShipments(): void
    {
        $this->getDocument()->pressButton('Export all new shipments');
    }

    public function exportFirsShipment(): void
    {
        $this->getDocument()->find('css', '.shipping-export-state')->click();
    }
}

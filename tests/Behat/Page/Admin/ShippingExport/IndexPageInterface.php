<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingExport;

use Behat\Mink\Element\ElementInterface;
use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPage;

interface IndexPageInterface extends BaseIndexPage
{
    /**
     * @param string $state
     *
     * @return ElementInterface[]
     */
    public function getShipmentsWithState(string $state): array;

    public function exportAllShipments(): void;

    public function exportFirsShipment(): void;
}

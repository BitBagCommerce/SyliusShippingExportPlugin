<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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

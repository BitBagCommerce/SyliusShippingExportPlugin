<?php

declare(strict_types=1);
/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingExport;

use Behat\Mink\Element\ElementInterface;
use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface IndexPageInterface extends BaseIndexPage
{
    /**
     * @param $state
     *
     * @return ElementInterface[]|null
     */
    public function getShipmentsWithState($state);

    public function exportAllShipments();

    public function exportFirsShipment();
}

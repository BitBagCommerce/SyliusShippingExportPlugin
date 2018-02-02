<?php

declare(strict_types=1);
/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingExport;

use Behat\Mink\Element\ElementInterface;
use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getShipmentsWithState($state)
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

    /**
     * {@inheritdoc}
     */
    public function exportAllShipments()
    {
        $this->getDocument()->pressButton('Export all new shipments');
    }

    /**
     * {@inheritdoc}
     */
    public function exportFirsShipment()
    {
        $this->getDocument()->find('css', '.shipping-export-state')->click();
    }
}

<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingGateway;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\SyliusShippingExportPlugin\Behat\Behaviour\ContainsError;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ContainsError;

    /**
     * {@inheritdoc}
     */
    public function selectShippingMethod($name)
    {
        $this->getDocument()->selectFieldOption('Shipping method', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function fillField($field, $value)
    {
        $this->getDocument()->fillField($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function submit()
    {
        $this->saveChanges();
    }
}

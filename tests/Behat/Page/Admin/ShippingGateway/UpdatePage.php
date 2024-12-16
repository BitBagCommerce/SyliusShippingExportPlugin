<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingGateway;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\SyliusShippingExportPlugin\Behat\Behaviour\ContainsError;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ContainsError;

    public function selectShippingMethod(string $name): void
    {
        $this->getDocument()->selectFieldOption('Shipping method', $name);
    }

    public function fillField(string $field, $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function submit(): void
    {
        $this->saveChanges();
    }
}

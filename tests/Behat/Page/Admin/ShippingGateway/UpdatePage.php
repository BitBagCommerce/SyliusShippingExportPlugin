<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

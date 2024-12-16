<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingGateway;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePage;

interface UpdatePageInterface extends BaseUpdatePage
{
    public function selectShippingMethod(string $name): void;

    public function fillField(string $field, $value): void;

    public function submit(): void;
}

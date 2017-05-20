<?php

namespace Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function selectShippingMethod($name);

    public function fillField($field, $value);

    public function submit();

    public function containsSuccessNotification($message = null);

    public function containsErrorNotification($message = null);
}
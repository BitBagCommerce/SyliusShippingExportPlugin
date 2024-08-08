<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Context;

use BitBag\SyliusShippingExportPlugin\Exception\ShippingGatewayNotFoundException;

interface ShippingGatewayContextInterface
{
    public function getFormType(): ?string;

    /**
     * @throws ShippingGatewayNotFoundException
     */
    public function getCode(): ?string;

    public function getLabelByCode(?string $code): ?string;
}

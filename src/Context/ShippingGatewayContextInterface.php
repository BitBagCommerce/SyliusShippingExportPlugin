<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Context;

use BitBag\SyliusShippingExportPlugin\Exception\ShippingGatewayNotFoundException;

interface ShippingGatewayContextInterface
{
    public function getFormType(): ?string;

    /**
     * @return string|null
     *
     * @throws ShippingGatewayNotFoundException
     */
    public function getCode(): ?string;

    public function getLabelByCode(?string $code): ?string;
}

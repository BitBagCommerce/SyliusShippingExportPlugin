<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Exception;

final class ShippingGatewayLabelNotFound extends \Exception
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('Shipping gateway label for %s code was not found.', $code));
    }
}

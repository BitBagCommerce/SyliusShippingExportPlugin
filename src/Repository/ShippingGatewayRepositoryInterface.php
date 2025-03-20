<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Repository;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

interface ShippingGatewayRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    public function findOneByCode(string $code): ?ShippingGatewayInterface;

    public function findOneByShippingMethod(ShippingMethodInterface $shippingMethod): ?ShippingGatewayInterface;
}

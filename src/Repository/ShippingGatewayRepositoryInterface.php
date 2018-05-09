<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Repository;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;

interface ShippingGatewayRepositoryInterface extends RepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder(): QueryBuilder;

    /**
     * @param string $code
     *
     * @return ShippingGatewayInterface
     */
    public function findOneByCode(string $code): ?ShippingGatewayInterface;

    /**
     * @param ShippingMethodInterface $shippingMethod
     *
     * @return ShippingGatewayInterface
     */
    public function findOneByShippingMethod(ShippingMethodInterface $shippingMethod): ?ShippingGatewayInterface;
}

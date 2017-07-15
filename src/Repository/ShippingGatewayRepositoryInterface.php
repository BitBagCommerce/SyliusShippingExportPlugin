<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Repository;

use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ShippingGatewayRepositoryInterface extends RepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder();

    /**
     * @param string $code
     *
     * @return ShippingGatewayInterface|null
     */
    public function findOneByCode($code);

    /**
     * @param ShippingMethodInterface $shippingMethod
     *
     * @return ShippingMethodInterface|null
     */
    public function findOneByShippingMethod(ShippingMethodInterface $shippingMethod);
}
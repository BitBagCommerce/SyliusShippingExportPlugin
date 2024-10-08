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
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;

class ShippingGatewayRepository extends EntityRepository implements ShippingGatewayRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o');
    }

    public function findOneByCode(string $code): ?ShippingGatewayInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByShippingMethod(ShippingMethodInterface $shippingMethod): ?ShippingGatewayInterface
    {
        return $this->createQueryBuilder('o')
            ->where(':shippingMethod MEMBER OF o.shippingMethods')
            ->setParameter('shippingMethod', $shippingMethod)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}

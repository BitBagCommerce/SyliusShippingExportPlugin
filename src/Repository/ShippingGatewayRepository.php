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
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;

class ShippingGatewayRepository extends EntityRepository implements ShippingGatewayRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o');
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByCode(string $code): ?ShippingMethodInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
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

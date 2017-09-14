<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\ShippingExportPlugin\Repository;

use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class ShippingGatewayRepository extends EntityRepository implements ShippingGatewayRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(): ?QueryBuilder
    {
        return $this->createQueryBuilder('o');
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByCode(?string $code): ?ShippingGatewayInterface
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
    public function findOneByShippingMethod(?ShippingMethodInterface $shippingMethod): ?ShippingMethodInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.shippingMethod = :shippingMethod')
            ->setParameter('shippingMethod', $shippingMethod)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
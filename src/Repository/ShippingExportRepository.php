<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Repository;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ShippingExportRepository extends EntityRepository implements ShippingExportRepositoryInterface
{
    public const NEW_STATE_PARAMETER = 'newState';

    public const PENDING_STATE_PARAMETER = 'pendingState';

    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.shipment', 'shipment')
        ;
    }

    /**
     * @inheritdoc
     */
    public function findAllWithNewState(): array
    {
        trigger_deprecation('bitbag/shipping-export-plugin', '1.6', 'The "%s()" method is deprecated, use "ShippingExportRepository::findAllWithNewOrPendingState" instead.', __METHOD__);

        return $this->createQueryBuilder('o')
            ->where('o.state = :newState')
            ->setParameter(self::NEW_STATE_PARAMETER, ShippingExportInterface::STATE_NEW)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllWithNewOrPendingState(): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.state = :newState OR o.state = :pendingState')
            ->setParameter(self::NEW_STATE_PARAMETER, ShippingExportInterface::STATE_NEW)
            ->setParameter(self::PENDING_STATE_PARAMETER, ShippingExportInterface::STATE_PENDING)
            ->getQuery()
            ->getResult()
        ;
    }
}

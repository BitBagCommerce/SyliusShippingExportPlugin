<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

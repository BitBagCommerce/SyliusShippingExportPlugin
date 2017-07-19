<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Repository;

use BitBag\ShippingExportPlugin\Entity\ShippingExportInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class ShippingExportRepository extends EntityRepository implements ShippingExportRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder()
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.shipment', 'shipment')
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllWithNewState()
    {
        return $this->createQueryBuilder('o')
            ->where('o.state = :newState')
            ->setParameter('newState', ShippingExportInterface::STATE_NEW)
            ->getQuery()
            ->getResult();
    }
}
<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ShippingExportRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    /**
     * @depracated since SyliusShippingExportPlugin 1.6, use ShippingExportRepository::findAllWithNewOrPendingState instead.
     */
    public function findAllWithNewState(): array;

    public function findAllWithNewOrPendingState(): array;
}

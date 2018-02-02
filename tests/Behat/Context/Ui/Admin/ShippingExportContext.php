<?php

declare(strict_types=1);
/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingExport\IndexPageInterface;
use Webmozart\Assert\Assert;

final class ShippingExportContext implements Context
{
    /**
     * @var IndexPageInterface
     */
    private $indexPage;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @param IndexPageInterface $indexPage
     * @param NotificationCheckerInterface $notificationChecker
     */
    public function __construct(
        IndexPageInterface $indexPage,
        NotificationCheckerInterface $notificationChecker
    ) {
        $this->indexPage = $indexPage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When I go to the shipping export page
     */
    public function iGoToTheShippingExportPage()
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :number shipments with :state state
     * @Then all :number shipments should have :state state
     * @Then :number shipments should have :state state
     */
    public function iShouldSeeNewShipmentsToExportWithState($number, $state)
    {
        Assert::eq((int) $number, count($this->indexPage->getShipmentsWithState($state)));
    }

    /**
     * @When I export all new shipments
     */
    public function iExportAllNewShipments()
    {
        $this->indexPage->exportAllShipments();
    }

    /**
     * @When I export first shipment
     */
    public function iExportFirsShipments()
    {
        $this->indexPage->exportFirsShipment();
    }

    /**
     * @Then I should be notified that the shipment has been exported
     */
    public function iShouldBeNotifiedThatTheShipmentHasBeenExported()
    {
        $this->notificationChecker->checkNotification(
            'Shipment data has been exported.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that there are no new shipments to export
     */
    public function iShouldBeNotifiedThatThereAreNoNewShipmentsToExport()
    {
        $this->notificationChecker->checkNotification(
            'There are no new shipments to export.',
            NotificationType::failure()
        );
    }

    /**
     * @Then I should be notified that an error occurred while trying to export shipping data
     */
    public function iShouldBeNotifiedThatAnErrorOccurredWhileTryingToExportShippingData()
    {
        $this->notificationChecker->checkNotification(
            'An external error occurred while trying to export shipping data.',
            NotificationType::failure()
        );
    }
}

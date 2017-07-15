<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\ShippingExportPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingExport\IndexPageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
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
    )
    {
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
     * @Then I should see :number shipments with :status status
     * @Then all :number shipments should have :status status
     * @Then :number shipments should have :status status
     */
    public function iShouldSeeNewShipmentsToExportWithStatus($number, $status)
    {
        Assert::eq((int)$number, count($this->indexPage->getShipmentsWithState($status)));
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
        $this->notificationChecker->checkNotification("shipment has been exported", NotificationType::success());
    }
}
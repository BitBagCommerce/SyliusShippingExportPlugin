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
use Sylius\Behat\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway\CreatePageInterface;
use Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway\UpdatePageInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayContext implements Context
{
    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @var UpdatePageInterface
     */
    private $updatePage;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     * @param CurrentPageResolverInterface $currentPageResolver
     * @param SharedStorageInterface $sharedStorage
     * @param NotificationCheckerInterface $notificationChecker
     */
    public function __construct(
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        CurrentPageResolverInterface $currentPageResolver,
        SharedStorageInterface $sharedStorage,
        NotificationCheckerInterface $notificationChecker
    )
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->currentPageResolver = $currentPageResolver;
        $this->sharedStorage = $sharedStorage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When I visit the create shipping gateway configuration page
     * @When I visit the update shipping gateway configuration page
     */
    public function iVisitTheShippingGatewayConfigurationPage()
    {
        $this->resolveCurrentPage()->open();
    }

    /**
     * @When I select the :name shipping method
     */
    public function iSelectTheShippingMethod($name)
    {
        $this->resolveCurrentPage()->selectShippingMethod($name);
    }

    /**
     * @When I fill the :field field with :value
     */
    public function iFillTheFieldWith($field, $value)
    {
        $this->resolveCurrentPage()->fillField($field, $value);
    }

    /**
     * @When I try to add it
     * @When I save it
     */
    public function iTryToAddIt()
    {
        $this->resolveCurrentPage()->submit();
    }

    /**
     * @Then I should be notified that the shipping gateway was created
     */
    public function iShouldBeNotifiedThatTheShippingGatewayWasCreated()
    {
        $this->notificationChecker->checkNotification("Shipping gateway was created.", NotificationType::success());
    }

    /**
     * @Then empty fields error should be displayed
     */
    public function emptyFieldsErrorShouldBeDisplayed()
    {
        $this->resolveCurrentPage()->getValidationMessage("Cannot be empty.");
    }

    /**
     * @return CreatePageInterface|UpdatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage()
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->createPage,
            $this->updatePage
        ]);
    }

}

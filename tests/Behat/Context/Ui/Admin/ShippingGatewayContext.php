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
use Tests\BitBag\ShippingExportPlugin\Behat\Behaviour\ContainsError;
use Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway\CreatePageInterface;
use Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway\UpdatePageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayContext implements Context
{
    /**
     * @var CreatePageInterface|ContainsError
     */
    private $createPage;

    /**
     * @var UpdatePageInterface|ContainsError
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
     * @When I visit the create shipping gateway configuration page for :code
     */
    public function iVisitTheCreateShippingGatewayConfigurationPage($code)
    {
        $this->createPage->open(['code' => $code]);
    }

    /**
     * @When I visit the update shipping gateway configuration page
     */
    public function iVisitTheUpdateShippingGatewayConfigurationPage()
    {
        $this->updatePage->open();
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
     * @When I clear the :field field
     */
    public function iClearTheField($field)
    {
        $this->resolveCurrentPage()->fillField($field, "");
    }

    /**
     * @When I add it
     * @When I save it
     */
    public function iTryToAddIt()
    {
        $this->resolveCurrentPage()->submit();
    }

    /**
     * @Then I should be notified that the shipping gateway has been created
     * @Then I should be notified that the shipping gateway has been updated
     */
    public function iShouldBeNotifiedThatTheShippingGatewayWasCreated()
    {
        $this->notificationChecker->checkNotification(
            "Shipping gateway has been successfully",
            NotificationType::success()
        );
    }

    /**
     * @Then :message error message should be displayed
     */
    public function errorMessageForFieldShouldBeDisplayed($message)
    {
        Assert::true($this->resolveCurrentPage()->hasError($message));
    }

    /**
     * @return CreatePageInterface|UpdatePageInterface|ContainsError|SymfonyPageInterface
     */
    private function resolveCurrentPage()
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->createPage,
            $this->updatePage
        ]);
    }

}

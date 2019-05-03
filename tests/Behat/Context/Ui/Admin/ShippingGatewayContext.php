<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusShippingExportPlugin\Behat\Behaviour\ContainsError;
use Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingGateway\CreatePageInterface;
use Tests\BitBag\SyliusShippingExportPlugin\Behat\Page\Admin\ShippingGateway\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ShippingGatewayContext implements Context
{
    /** @var CreatePageInterface|ContainsError */
    private $createPage;

    /** @var UpdatePageInterface|ContainsError */
    private $updatePage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    public function __construct(
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        CurrentPageResolverInterface $currentPageResolver,
        SharedStorageInterface $sharedStorage,
        NotificationCheckerInterface $notificationChecker
    ) {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->currentPageResolver = $currentPageResolver;
        $this->sharedStorage = $sharedStorage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When I visit the create shipping gateway configuration page for :code
     */
    public function iVisitTheCreateShippingGatewayConfigurationPage(string $code): void
    {
        $this->createPage->open(['code' => $code]);
    }

    /**
     * @When I visit the update shipping gateway configuration page
     */
    public function iVisitTheUpdateShippingGatewayConfigurationPage(): void
    {
        $this->updatePage->open();
    }

    /**
     * @When I select the :name shipping method
     */
    public function iSelectTheShippingMethod(string $name): void
    {
        $this->resolveCurrentPage()->selectShippingMethod($name);
    }

    /**
     * @When I fill the :field field with :value
     */
    public function iFillTheFieldWith(string $field, $value): void
    {
        $this->resolveCurrentPage()->fillField($field, $value);
    }

    /**
     * @When I clear the :field field
     */
    public function iClearTheField(string $field): void
    {
        $this->resolveCurrentPage()->fillField($field, '');
    }

    /**
     * @When I add it
     * @When I save it
     */
    public function iTryToAddIt(): void
    {
        $this->resolveCurrentPage()->submit();
    }

    /**
     * @Then I should be notified that the shipping gateway has been created
     * @Then I should be notified that the shipping gateway has been updated
     */
    public function iShouldBeNotifiedThatTheShippingGatewayWasCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Shipping gateway has been successfully',
            NotificationType::success()
        );
    }

    /**
     * @Then :message error message should be displayed
     */
    public function errorMessageForFieldShouldBeDisplayed(string $message): void
    {
        Assert::true($this->resolveCurrentPage()->hasError($message));
    }

    /**
     * @return CreatePageInterface|UpdatePageInterface|ContainsError|SymfonyPageInterface
     */
    public function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->createPage,
            $this->updatePage,
        ]);
    }
}

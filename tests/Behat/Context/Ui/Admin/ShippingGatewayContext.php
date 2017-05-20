<?php

namespace Tests\BitBag\ShippingExportPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway\CreatePageInterface;

final class ShippingGatewayContext implements Context
{
    private $createPage;

    private $sharedStorage;

    public function __construct(
        CreatePageInterface $createPage,
        SharedStorageInterface $sharedStorage
    )
    {
        $this->createPage = $createPage;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @When I visit the create shipping gateway configuration page
     */
    public function iVisitTheCreateShippingGatewayConfigurationPage()
    {
        $this->createPage->open();
    }

    /**
     * @When I select the :name shipping method
     */
    public function iSelectTheShippingMethod($name)
    {
        $this->createPage->selectShippingMethod($name);
    }

    /**
     * @When I fill the :field field with :value
     */
    public function iFillTheFieldWith($field, $value)
    {
        $this->createPage->fillField($field, $value);
    }

    /**
     * @When I try to add it
     */
    public function iTryToAddIt()
    {
        $this->createPage->submit();
    }

    /**
     * @Then I should be notified that the shipping gateway was created
     */
    public function iShouldBeNotifiedThatTheShippingGatewayWasCreated()
    {
        $this->createPage->containsSuccessNotification("Shipping gateway was created");
    }

    /**
     * @Then empty fields error should be displayed
     */
    public function emptyFieldsErrorShouldBeDisplayed()
    {
        $this->createPage->containsErrorNotification("Cannot be empty");
    }
}

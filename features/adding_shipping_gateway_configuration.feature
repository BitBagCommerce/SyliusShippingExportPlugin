@managing_shipping_gateway
Feature: Creating shipping gateway
    In order to export shipping data to external shipping provider service
    As an Administrator
    I want to be able to add new shipping method gateway with shipping method

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator
        And the store has "Frank Martin Parcels" shipping method with "$10.00" fee
        And I am able to create a shipping gateway with "Frank Martin Parcels Gateway" name and "transporter_gateway" code
        And "name", "address", "iban" configuration fields
        And "IBAN, Sender name, Sender address" fields can be configured for this gateway

    @ui
    Scenario: Creating Frank Martin Parcels shipping gateway
        When I visit the create shipping gateway configuration page
        And I select the "Frank Martin Parcels" shipping method
        And I fill the "IBAN" field with "GB29 RBOS 6016 1331 9268 19
        And I fill the "Sender name" field with "Nicolas King"
        And I fill the "Sender address" field with "85, 41121 Modena MO, Italy"
        And I try to add it
        Then I should be notified that the shipping gateway was created

    @ui
    Scenario: Trying to create shipping gateway with invalid data
        When I visit the create shipping gateway configuration page
        And I try to add it
        Then empty fields error should be displayed
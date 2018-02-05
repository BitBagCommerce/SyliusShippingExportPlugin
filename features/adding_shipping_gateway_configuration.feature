@managing_shipping_gateway
Feature: Creating shipping gateway
    In order to export shipping data to external shipping provider service
    As an Administrator
    I want to be able to add new shipping gateway with shipping method

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator
        And the store has "Frank Martin Parcels" shipping method with "$10.00" fee

    @ui
    Scenario: Creating Frank Martin Parcels shipping gateway
        When I visit the create shipping gateway configuration page for "frank_martin_shipping_gateway"
        And I select the "Frank Martin Parcels" shipping method
        And I fill the "IBAN" field with "GB29 RBOS 6016 1331 9268 19"
        And I fill the "Address" field with "Nick King, Main Square 27, Opole 45015, Poland"
        And I add it
        Then I should be notified that the shipping gateway has been created

    @ui
    Scenario: Trying to create shipping gateway with invalid data
        When I visit the create shipping gateway configuration page for "frank_martin_shipping_gateway"
        And I add it
        Then "IBAN number cannot be blank." error message should be displayed
        And "Address cannot be blank." error message should be displayed

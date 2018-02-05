@managing_shipping_gateway
Feature: Managing shipping gateway
    In order to export shipping data to external shipping provider service
    As an Administrator
    I want to be able to add manage shipping gateways

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator
        And the store has "Frank Martin Parcels" shipping method with "$10.00" fee
        And there is a registered "frank_martin_shipping_gateway" shipping gateway for this shipping method named "Transporter Gateway"
        And it has "IBAN" field set to "GB29 RBOS 6016 1331 9268 19"
        And it has "Address" field set to "Nick King, Main Square 27, Opole 45015, Poland"

    @ui
    Scenario: Creating Frank Martin Parcels shipping gateway
        When I visit the create shipping gateway configuration page for "frank_martin_shipping_gateway"
        And I select the "Frank Martin Parcels" shipping method
        And I fill the "IBAN" field with "FR14 2004 1010 0505 0001 3M02 606"
        And I fill the "Address" field with "Michael König, Champ de Mars, 5 Avenue Anatole France"
        And I save it
        Then I should be notified that the shipping gateway has been updated

    @ui
    Scenario: Trying to create shipping gateway with invalid data
        When I visit the create shipping gateway configuration page for "frank_martin_shipping_gateway"
        And I clear the "IBAN" field
        And I clear the "Address" field
        And I save it
        Then "IBAN number cannot be blank." error message should be displayed
        And "Address cannot be blank." error message should be displayed

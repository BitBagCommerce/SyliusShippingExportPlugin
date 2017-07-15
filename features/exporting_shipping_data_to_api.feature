@managing_shipping_export
Feature: Managing shipping gateway
    In order to export shipping data to external shipping provider service
    As an Administrator
    I want to be able to export shipments to external API

    Background:
        Given the store operates on a single channel in the "United States" named "Web-US"
        And I am logged in as an administrator
        And the store has "Frank Martin Parcels" shipping method with "$10.00" fee
        And there is a registered shipping gateway for this shipping method
        And it has "IBAN" field set to "GB29 RBOS 6016 1331 9268 19"
        And it has "Address" field set to "Nick King, Main Square 27, Opole 45015, Poland"
        And this shipping gateway has "frank_martin_shipping_gateway" code and "Frank Martin Parcels" label
        And the store has a product "Chicken" priced at "$2" in "Web-US" channel
        And customer "mikolaj.krol@bitbag.pl" has placed 5 orders on the "Web-US" channel in each buying 5 "Chicken" products
        And those orders were placed with "Frank Martin Parcels" shipping method

    @ui
    Scenario: Seeing shipments to export
        When I go to the shipping export page
        Then I should see 5 shipments with "New" status

    @ui
    Scenario: Exporting all new shipments
        When I go to the shipping export page
        And I export all new shipments
        Then I should be notified that the shipment has been exported
        And all 5 shipments should have "exported" status

    @ui
    Scenario: Exporting few new shipments
        When I go to the shipping export page
        And I export first shipment
        Then I should be notified that the shipment has been exported
        And 1 shipments should have "Exported" status
        And 4 shipments should have "New" status
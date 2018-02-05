@managing_shipping_export
Feature: Preparing shipping export after processing order with shipping gateway
    In order to export shipping data to external API
    As an Administrator
    I want to have prepared data for any placed order with shipping gateway

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "Ferrari Testarossa" priced at "$250000.00"
        And the store has "Frank Martin Parcels" shipping method with "$10.00" fee
        And there is a registered "frank_martin_shipping_gateway" shipping gateway for this shipping method named "Transporter Gateway"
        And the store allows paying "Cash on Delivery"
        And I am a logged in customer

    @ui
    Scenario: Receiving a discount on an order if it's nth order placed
        Given I have already placed 2 orders choosing "Ferrari Testarossa" product, "Frank Martin Parcels" shipping method to "United States" with "Cash on Delivery" payment
        And those orders were completed
        Then 2 new shipping exports should be created

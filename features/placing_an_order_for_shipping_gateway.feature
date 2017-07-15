@managing_shipping_export
Feature: Preparing suitable shipment data while placing an order
    In order to prepare data that is ready to export
    As an Administrator
    I want to be able to see converted order in admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator
        And the store has "Frank Martin Parcels" shipping method with "$10.00" fee
        And there is a registered shipping gateway for this shipping method
        And this shipping gateway has "frank_martin_shipping_gateway" code and "Frank Martin Parcels" label

    @ui
    Scenario: Placing new order with shipping gateway
        Given I had product "PHP T-Shirt" in the cart
        And I specified the shipping address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I have proceeded selecting "Frank Martin Parcels" shipping method
        Then new shipping to export with "new" status should appear

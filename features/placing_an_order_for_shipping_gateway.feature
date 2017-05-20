@preparing_shipment_data
Feature: Preparing suitable shipment data while placing an order
  In order to prepare data that is ready to export
  As an Administrator
  I want to be able to see converted order in admin panel

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator
    And there is a shipping method named "Frank Martin Parcels" with "transporter" code
    And it has a configured gateway named "Frank Martin Parcels Gateway" with "transporter_export" code
    And this gateway is configurable with "Bank account number, Pickup start hour, Pickup end hour, Pickup address street, Pickup address city, Pickup address post code" gateway configuration fields

  @ui
  Scenario: Placing new order with shipping gateway
    Given I had product "PHP T-Shirt" in the cart
    And I specified the shipping address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
    And I have proceeded selecting "Free" shipping method
    Then new shipping data should be ready to export with proper data for "transporter" gateway

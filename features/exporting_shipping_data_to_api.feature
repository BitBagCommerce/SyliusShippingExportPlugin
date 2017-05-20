@managing_shipping_data
Feature: Exporting specific shipping data to external API
  In order to export shipping data to a shipping provider API
  As an Administrator
  I want to be able to modify and select data to export

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator
    And there is a shipping method named "Frank Martin Parcels" with "transporter" code
    And it has a configured gateway named "Frank Martin Parcels Gateway" with "transporter_export" code
    And this gateway is configurable with "Bank account number, Pickup start hour, Pickup end hour, Pickup address street, Pickup address city, Pickup address post code" gateway configuration fields

  @ui
  Scenario: Being able to export new shipments
    Given there are "3" new orders placed with "transporter" shipping method
    When I go to the shipments page
    Then I should see "3" new orders that are ready to export

  @ui
  Scenario: Exporting all new shipments
    Given there are "3" new orders placed with "transporter" shipping method
    When I go to the shipments page
    And I filter the results to show only "Frank Martin Parcels" shipments
    And I click the "Export all new shipments" button
    Then I should be notified that "3" new shipments were exported to "Frank Martin Parcels" system
    And all "Frank Martin Parcels" shipments should be marked as "Exported"

  @ui
  Scenario: Exporting a few new shipments
    Given there are "3" new orders placed with "transporter" shipping method
    When I go to the shipments page
    And I filter the results to show only "Frank Martin Parcels" shipments
    And I select "2" first shipments to export
    And I click the "Export selected shipments" button
    Then I should be notified that "2" shipments were exported to "Frank Marting Parcels" system
    And "2" "Frank Martin Parcels" shipments should be marked as "NEW"

  @ui
  Scenario: Updating shipment export data
    Given there are "3" new orders placed with "transporter" shipping method
    When I go to the shipments page
    And I filter the results to show only "Frank Martin Parcels" shipments
    And I select edit button on first shipment
    Then I should be on the update shipment data page
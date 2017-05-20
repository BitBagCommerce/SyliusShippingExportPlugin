@managing_shipping_data
Feature: Updating shipping data before exporting it
  In order to export shipping data to a shipping provider API
  As an Administrator
  I want to be able to edit specific shipments before export

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator
    And there is a shipping method named "Frank Martin Parcels" with "transporter" code
    And it has a configured gateway named "Frank Martin Parcels Gateway" with "transporter_export" code
    And it is configurable with "First name, Last name" fields

  @ui
  Scenario: Updating shipping data before export
    Given there is a new order placed with "Frank Martin Parcels" shipment which is not exported yet
    When I go to the new order's data page
    And I change the "First name" field to "Nicolas"
    And I change the "Last name" field to "King"
    And I save it
    Then I should be on the index page
    And I should be notified that shipping data was updated
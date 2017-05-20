@managing_shipping_gateway
Feature: Creating shipping gateway order
  In order to export shipping data to transform order to agnostic shipping provider format
  As a customer
  I want to be able to create shipping gateway order during placing new order

  Background:
    Given the store operates on a single channel in "United States"
    And there is a user "shop@example.com" identified by "somepassword"
    And I am logged in as "shop@example.com"

  @ui
  Scenario: Placing new order and creating new shipping gateway order
    Given I am at the checkout addressing step
    When I specify the shipping address for "Patrick Jane" from "Sixth Street", "78701", "Austin", "United States", "Texas"
    And I complete the addressing step
    And I proceed with "Free" shipping method and "Offline" payment
    And I confirm my order
    Then the new shipping gateway order should be created with "Sixth Street" street, "Patrick Jane" receiver name

  @ui
    #@TODO: gateway and shipping method background
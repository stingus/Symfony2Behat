Feature: Scientific calculator
  In order to do science
  As a scientist
  I want to add, substract, multiply and divide numbers

  Scenario: Adding two numbers
    Given I have the number "1" and the number "9"
    When I add them
    Then I want to get the result "10"

  Scenario: Persist the result
    Given I have the number "2" and the number "5"
    When I add them
    Then I want the calculator result to be persisted

  @javascript
  Scenario: Adding two numbers on the UI
    Given I am on the homepage
    When I fill in "First" with "2"
    And I fill in "Second" with "3"
    And I press "Add"
    Then I should see "Result: 5"

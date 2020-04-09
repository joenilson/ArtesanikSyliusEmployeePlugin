# Sylius/Sylius:features/customer/managing_customers/adding_employee_attributes.feature

@managin_customers
Feature: Adding a new customer
    I order to sell my goods to my own employees
    I want to add a new fields to the Customer Model

    Background:
    Given I am logged in as an administrator

    @ui
    Scenario: Adding customer
        When I want to add a new customer
        And I click the Create button
        Then I should see and fill the new fields with the Employee attributes

    Scenario: Editing customer
        When i see the details of a customer
        And i click the Edit button
        Then i shlould update the fields with the Employee attributes


Feature: Show Account info for customer
    I login in the store as a customer
    I check My Profile
    I se my employee info in read only mode

    Background:
    Given I am logged as an customer

    @ui
    Scenario: Login as customer
    When I'm logged as customer
    And I go to My Profile
    Then I should see my employee info in read only mode
        
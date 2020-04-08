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
        And I choose the group Employees
        Then I should see the new fields with the Employee attributes
        
        
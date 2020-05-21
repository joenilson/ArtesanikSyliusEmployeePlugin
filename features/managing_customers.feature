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

Feature: Add employee id in checkout process

    @ui
    I login in the store as a customer
    I choose products to buy
    I go to checkout
    I add my information and confirm my employee_id
    then i shloud complete the checkout process

Feature: Limit the shipping total amount of units quantity to buy in a period of time
    I'm an employee trying to shop
    I have an amount or units quantity in a period of time
    I can't shop more than the limit

    Background:
    Given I am logged in as an administrator
    I setup a channel as a internal shopping store
    I setup the rules for employees limits
    I create the rule details
    I run the rules for all the employees
    I check if some employees must to be out of the limit rule

    @ui
    I login in the store as a customer/employee
    I see the banner with info about my limit and avaliable balance
    If i have avaliable balance
    I pick some items to the shopping cart
    If i don't see an alert then i go to checkout
    I finish the process doing the checkout
    If i don't have available balance
    I can't make a purchase

    
<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Plugin Employee</h1>

<p align="center">Plugin for company internal stores for employees.</p>

## Documentation

This plugin is simple add four fields to the customer model: EmployeeId, Position, Office and Company

This informatión can be edited in the Admin shop interface.

The user can see this information but isn't allowed to modify this information.

That is for securing the information.

It has two translations:

- English
- Spanish

More translations are welcome as PR.

It have a top limit control, you can create Limits in money or quantity and apply to the employees.

And you can put an employee excluded from the limit, all this from the admin dashboard.

## Installation

1. Require plugin with composer

```
composer require artesanik/sylius-employee-plugin
```

2. Register the Plugin in config/bundles.php:

```
....
Artesanik\SyliusEmployeePlugin\ArtesanikSyliusEmployeePlugin::class => ['all' => true],
....
```

3. create a file sylius_employee_plugin.yaml in config/packages

```
cd config/packages
touch sylius_employee_plugin.yaml
nano sylius_employee_plugin.yaml
```

- and put this lines inside:

```
imports:
    - { resource: "@ArtesanikSyliusEmployeePlugin/Resources/config/config.yml" }
```

4. create a file sylius_employee_plugin.yaml in config/routes

```
cd config/routes
touch sylius_employee_plugin.yaml
nano sylius_employee_plugin.yaml
```

- and put this lines inside

```
artesanik_sylius_employee_plugin:
    resource: "@ArtesanikSyliusEmployeePlugin/Resources/config/routes.yml"
```

5. Copy plugin migrations to your migrations directory (e.g. src/Migrations) and apply them to your database:

```
cp -R vendor/artesanik/sylius-employee-plugin/migrations/* src/Migrations
bin/console doctrine:migrations:migrate
```

remember to make a 

```
bin/console cache:clear
```

At the end of the install


## COMPLETED
- [X] Add employee purchase budget [v0.3]

## TODO

- [ ] Add EmployeeId to Order
- [ ] Add compatibility with SyliusLdapPlugin
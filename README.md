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

## Installation

1. Require plugin with composer

```
composer require artesanik/sylius-employee-plugin
```

2. Copy Sylius templates overridden in plugin to your templates directory (e.g templates/bundles/):

```
mkdir -p templates/bundles/SyliusAdminBundle/
cp -R vendor/artesanik/sylius-employee-plugin/src/Resources/views/SyliusAdminBundle/* templates/bundles/SyliusAdminBundle/
```

Copy plugin migrations to your migrations directory (e.g. src/Migrations) and apply them to your database:

```
cp -R vendor/artesanik/sylius-employee-plugin/migrations/* src/Migrations
bin/console doctrine:migrations:migrate
```

## TODO

[] Add EmployeeId to Order
[] Add employee purchase budget
[] Add compatibility with SyliusLdapPlugin
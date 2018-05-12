<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="https://raw.githubusercontent.com/bitbager/BitBagCommerceAssets/master/SyliusShippingExportPlugin.png" />
    </a>
    <br />
    <a href="https://packagist.org/packages/bitbag/shipping-export-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/bitbag/shipping-export-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/shipping-export-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/bitbag/shipping-export-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/BitBagCommerce/SyliusShippingExportPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/BitBagCommerce/SyliusShippingExportPlugin/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/BitBagCommerce/SyliusShippingExportPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/BitBagCommerce/SyliusShippingExportPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/shipping-export-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/bitbag/shipping-export-plugin/downloads" />
    </a>
</h1>

## Overview
Managing shipments in any eCommerce app is something that may be tricky. There are many shipping providers and every of them has probably its own API format which allows to provide shipment data and book a courier. To make this process more straight forward and generic, we decided to create an abstract layer for Sylius platform based applications which allows you to write just simple API call and configuration form for specific shipping provider. The workflow is quite simple - configure proper data that's needed to export a shipment, like access key or pickup hour, book a courier for an order with one click and get shipping label file if any was received from the API. The implementation limits to write a shipping provider gateway configuration form, one event listener and webservice access layer.

## Support

We work on amazing eCommerce projects on top of Sylius and Pimcore. Need some help or additional resources for a project?
Write us an email on mikolaj.krol@bitbag.pl or visit [our website](https://bitbag.shop/)! :rocket:

## Usage

Read [this blog post](https://bitbag.shop/blog/bitbag-shipping-export-plugin-simple-way-to-control-shipments-in-your-online-store) in order to start using this plugin.

## Testing

In order to run tests, execute following commands:

```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console doctrine:database:create --env test
$ bin/console doctrine:schema:create --env test
$ vendor/bin/behat
$ vendor/bin/phpspec
```

In order to open test app in your browser, do the following:

```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console doctrine:database:create --env test
$ bin/console doctrine:schema:create --env test
$ bin/console server:start --env test
$ open http://127.0.0.1:8000/
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/

## Support

Do you want us to customize this plugin for your specific needs? Write us an email on mikolaj.krol@bitbag.pl 💻

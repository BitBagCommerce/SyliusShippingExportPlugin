![BitBag](https://bitbag.pl/static/bitbag-logo.png)


# BitBag ShippingExportPlugin  [![Build Status](https://travis-ci.org/bitbag-commerce/shipping-export-plugin.svg?branch=master)](https://travis-ci.org/bitbag-commerce/shipping-export-plugin) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bitbag-commerce/shipping-export-plugin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bitbag-commerce/shipping-export-plugin/?branch=master)

## Overview
Managing shipments in any eCommerce app is something that may be tricky. There are many shipping providers and every of them has probably its own API format which allows to provide shipment data and book a courier. To make this process more straight forward and generic, we decided to create an abstract layer for Sylius platform based applications which allows you to write just simple API call and configuration form for specific shipping provider. The workflow is quite simple - configure proper data that's needed to export a shipment, like access key or pickup hour, book a courier for an order with one click and get shipping label file if any was received from the API. The implementation limits to write a shipping provider gateway configuration form, one event listener and webservice access layer.

## Usage

Read [this blog post](https://bitbag.shop/blog/post/bitbag-shipping-export-plugin-simple-way-to-control-shipments-in-your-online-store) in order to start using this plugin.

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

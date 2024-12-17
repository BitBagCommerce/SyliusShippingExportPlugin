# [![](https://bitbag.io/wp-content/uploads/2021/04/ShippingExportPlugin.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_shipping_export)

# BitBag SyliusShippingExportPlugin

----

[![](https://img.shields.io/packagist/l/bitbag/shipping-export-plugin.svg)](https://packagist.org/packages/bitbag/shipping-export-plugin "License") 
[![](https://img.shields.io/packagist/v/bitbag/shipping-export-plugin.svg)](https://packagist.org/packages/bitbag/shipping-export-plugin "Version")
[![](https://img.shields.io/github/actions/workflow/status/BitBagCommerce/SyliusShippingExportPlugin/build.yml?branch=master)](https://github.com/BitBagCommerce/SyliusShippingExportPlugin/actions "Build status")
[![](https://img.shields.io/scrutinizer/quality/g/BitBagCommerce/SyliusShippingExportPlugin.svg)](https://scrutinizer-ci.com/g/BitBagCommerce/SyliusShippingExportPlugin/ "Scrutinizer") 
[![](https://poser.pugx.org/bitbag/shipping-export-plugin/downloads)](https://packagist.org/packages/bitbag/shipping-export-plugin "Total Downloads")
[![Slack](https://img.shields.io/badge/community%20chat-slack-FF1493.svg)](http://sylius-devs.slack.com)
[![Support](https://img.shields.io/badge/support-contact%20author-blue])](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_shipping_export)

<p>
 <img align="left" src="https://sylius.com/assets/badge-approved-by-sylius.png" width="85">
</p> 

We want to impact many unique eCommerce projects and build our brand recognition worldwide, so we are heavily involved in creating open-source solutions, especially for Sylius. We have already created over 35 extensions, which have been downloaded almost 2 million times.

You can find more information about our eCommerce services and technologies on our website: https://bitbag.io/. We have also created a unique service dedicated to creating plugins: https://bitbag.io/services/sylius-plugin-development. 

Do you like our work? Would you like to join us? Check out the “Career” tab: https://bitbag.io/pl/kariera. 

# About us

BitBag is a software house that implements tailor-made eCommerce platforms with the entire infrastructure—from creating eCommerce platforms to implementing PIM and CMS systems to developing custom eCommerce applications, specialist B2B solutions, and migrations from other platforms.

We actively participate in Sylius's development. We have already completed over 150 projects, cooperating with clients from all over the world, including smaller enterprises and large international companies. We have completed projects for such important brands as **Mytheresa, Foodspring, Planeta Huerto (Carrefour Group), Albeco, Mollie, and ArtNight**.

We have a 70-person team of experts: business analysts and eCommerce consultants, developers, project managers, and QA testers.

**Our services:**
* B2B and B2C eCommerce platform implementations
* Multi-vendor marketplace platform implementations
* eCommerce migrations
* Sylius plugin development
* Sylius consulting
* Project maintenance and long-term support
* PIM and CMS implementations

**Some numbers from BitBag regarding Sylius:**
* 70 experts on board 
* +150 projects delivered on top of Sylius,
* 30 countries of BitBag’s customers,
* 7 years in the Sylius ecosystem.
* +35 plugins created for Sylius

***
[![](https://bitbag.io/wp-content/uploads/2024/09/badges-sylius.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=pluginsshippingexport)
***

## Table of Content

***

* [Overview](#overview)
* [Functionalities](#functionalities)
* [Installation](#installation)
    * [Requirements](#requirements)
    * [Usage](#usage)
    * [Testing](#testing)
* [Demo](#demo)
* [License](#license)
* [Contact and Support](#contact-and-support)
* [Community](#community)

# Overview

***

Managing shipments in any eCommerce app is something that may be tricky. There are many shipping providers, and each has its own API format you might want to use to export shipping data and request the pickup. To make this process simpler and generic, we created an abstract layer for Sylius platform-based applications. This plugin allows you to write simple API calls and configuration forms for specific shipping providers. The workflow is quite simple - configure the proper data that's needed to export a shipment, like access key or pickup hour, book a courier for an order with one click, and get a shipping label file if any was received from the API. The implementation limits to writing a shipping provider gateway configuration form, one event listener, and a web service access layer.

# Installation

For the full installation guide, please go [here](doc/installation.md).

----
## Requirements

We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.

| Package       | Version       |
|---------------|---------------|
| PHP           | \>=8.2        |
| sylius/sylius | 2.0.x         |
| MySQL         | \>= 8.0       |
| NodeJS        | \>=20.x, 22.x |

----

## Usage

### Adding shipping export configuration form

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class FrankMartinShippingGatewayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iban', TextType::class, [
                'label' => 'IBAN',
                'constraints' => [
                    new NotBlank([
                        'message' => 'IBAN number cannot be blank.',
                        'groups' => 'bitbag',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Address cannot be blank.',
                        'groups' => 'bitbag',
                    ]),
                ],
            ])
        ;
    }
}
```

#### Service definition
```yaml
services:
    app.form.type.frank_martin_shipping_gateway:
        class: App\Form\Type\FrankMartinShippingGatewayType
        tags:
            - { name: bitbag.shipping_gateway_configuration_type, type: "frank_martin_shipping_gateway", label: "Transporter Gateway" }
```

### Adding shipping export event listener
```php
<?php

declare(strict_types=1);

namespace App\EventListener;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RequestStack;
use Webmozart\Assert\Assert;

final class FrankMartinShippingExportEventListener
{
    /** @var RequestStack */
    private $requestStack;

    /** @var Filesystem */
    private $filesystem;

    /** @var ObjectManager */
    private $shippingExportManager;

    /** @var string */
    private $shippingLabelsPath;

    public function __construct(
        RequestStack $requestStack,
        Filesystem $filesystem,
        ObjectManager $shippingExportManager,
        string $shippingLabelsPath
    ) {
        $this->requestStack = $requestStack;
        $this->filesystem = $filesystem;
        $this->shippingExportManager = $shippingExportManager;
        $this->shippingLabelsPath = $shippingLabelsPath;
    }

    public function exportShipment(ResourceControllerEvent $event): void
    {
        /** @var ShippingExportInterface $shippingExport */
        $shippingExport = $event->getSubject();
        Assert::isInstanceOf($shippingExport, ShippingExportInterface::class);

        $shippingGateway = $shippingExport->getShippingGateway();
        Assert::notNull($shippingGateway);

        if ('frank_martin_shipping_gateway' !== $shippingGateway->getCode()) {
            return;
        }

        $session = $this->requestStack->getSession();
        $flashBag = $session->getBag('flashes');

        if (false) {
            $flashBag->add('error', 'bitbag.ui.shipping_export_error'); // Add an error notification

            return;
        }

        $flashBag->add('success', 'bitbag.ui.shipment_data_has_been_exported'); // Add success notification
        $this->saveShippingLabel($shippingExport, 'Some label content received from external API', 'pdf'); // Save label
        $this->markShipmentAsExported($shippingExport); // Mark shipment as "Exported"
    }

    public function saveShippingLabel(
        ShippingExportInterface $shippingExport,
        string $labelContent,
        string $labelExtension
    ): void {
        $labelPath = $this->shippingLabelsPath
            . '/' . $this->getFilename($shippingExport)
            . '.' . $labelExtension;

        $this->filesystem->dumpFile($labelPath, $labelContent);
        $shippingExport->setLabelPath($labelPath);

        $this->shippingExportManager->persist($shippingExport);
        $this->shippingExportManager->flush();
    }

    private function getFilename(ShippingExportInterface $shippingExport): string
    {
        $shipment = $shippingExport->getShipment();
        Assert::notNull($shipment);

        $order = $shipment->getOrder();
        Assert::notNull($order);

        $orderNumber = $order->getNumber();

        $shipmentId = $shipment->getId();

        return implode(
            '_',
            [
                $shipmentId,
                preg_replace('~[^A-Za-z0-9]~', '', $orderNumber),
            ]
        );
    }

    private function markShipmentAsExported(ShippingExportInterface $shippingExport): void
    {
        $shippingExport->setState(ShippingExportInterface::STATE_EXPORTED);
        $shippingExport->setExportedAt(new \DateTime());

        $this->shippingExportManager->persist($shippingExport);
        $this->shippingExportManager->flush();
    }
}
```

#### Service definition
```yaml
services:
    app.event_listener.frank_martin_shipping_export:
        class: App\EventListener\FrankMartinShippingExportEventListener
        arguments:
            - '@request_stack'
            - '@filesystem'
            - '@bitbag.manager.shipping_export'
            - '%bitbag.shipping_labels_path%'
        tags:
            - { name: kernel.event_listener, event: 'bitbag.shipping_export.export_shipment', method: exportShipment }
```

#### Plugin parameters
```yaml
parameters:
    bitbag.shipping_gateway.validation_groups: ['bitbag']
    bitbag.shipping_labels_path: '%kernel.project_dir%/shipping_labels'
```

### Available services you can [decorate](https://symfony.com/doc/current/service_container/service_decoration.html) and forms you can [extend](http://symfony.com/doc/current/form/create_form_type_extension.html)
```bash
$ bin/console debug:container | grep bitbag
```

### Parameters you can override in your parameters.yml(.dist) file
```bash
$ bin/console debug:container --parameters | grep bitbag
```

## Testing
```bash
$ composer install
$ APP_ENV=test symfony server:start --port=8080 --dir=tests/Application/public --daemon
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ shipping-export
$ open http://localhost:8080
$ vendor/bin/behat
$ vendor/bin/phpspec run
$ vendor/bin/phpstan analyse -c phpstan.neon -l max src/
$ vendor/bin/ecs check src
```
# Functionalities

All main functionalities of the plugin are described [here](https://github.com/BitBagCommerce/SyliusWishlistPlugin/blob/master/doc/functionalities.md).

---- 
# Demo

---

We created a demo app with some useful use-cases of plugins! Visit http://demo.sylius.com/ to take a look at it.

**If you need an overview of Sylius' capabilities, schedule a consultation with our expert.**

[![](https://bitbag.io/wp-content/uploads/2020/10/button_free_consulatation-1.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_shipping_export)

# Additional resources for developers

---
To learn more about our contribution workflow and more, we encourage you to use the following resources:
* [Sylius Documentation](https://docs.sylius.com/en/latest/)
* [Sylius Contribution Guide](https://docs.sylius.com/en/latest/contributing/)
* [Sylius Online Course](https://sylius.com/online-course/)
* [Sylius Shipping Export Plugin Blog](https://bitbag.io/blog/bitbag-shipping-export-plugin-simple-way-to-control-shipments-in-your-online-store)

# License

---
This plugin's source code is completely free and released under the terms of the MIT license.

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen.)

---
# Contact and Support

This open-source plugin was developed to help the Sylius community. If you have any additional questions, would like help with installing or configuring the plugin, or need any assistance with your Sylius project - let us know! **Contact us** or send us an **e-mail to hello@bitbag.io** with your question(s).

[![](https://bitbag.io/wp-content/uploads/2020/10/button-contact.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_shipping_export)

---
# Community

We invite you to chat with us & other users on [Sylius Slack](https://sylius-devs.slack.com/) for online communication.

[![](https://bitbag.io/wp-content/uploads/2024/09/badges-partners.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_shipping_export)

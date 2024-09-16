# Functionalities

---

There are many shipping providers and each has its own API format you might want to use to export shipping data and request the pickup. 
This plugin allows you to write simple API calls and configuration form for specific shipping provider. 

After installation, user is now able to create gateway for a specific shipping provider (of course the right configuration form must be firstly written). 

<div align="center">
    <img src="./images/shipping_gateways.png"/>
</div>

Once the shipping method and shipping gateway for the shipping provider are created, customer can use this shipping method during a checkout. 
When the order is placed, user can now go to the 'Export shipping data' section from Sylius Admin Panel and export chosen shipments.

<div align="center">
    <img src="./images/shipping_export.png"/>
</div>

## Development
The plugin in itself does not carry functionalities on an `out-of-the-box` basis, but provides an excellent framework for developers to write them.

The skeleton for creating such functionalities can be found under the tab: `USAGE` in the `README.md` file.

> Using the attached skeleton, at least 2 services are needed for the plugin to work:
- one - handling the form responsible for creating the `shipping gateway`;
- the other - responsible for handling the `export of the shipment`.

### Shipping Gateway configuration form
```yaml
services:
    app.form.type.frank_martin_shipping_gateway:
        class: App\Form\Type\FrankMartinShippingGatewayType
        tags:
            - { name: bitbag.shipping_gateway_configuration_type, type: "frank_martin_shipping_gateway", label: "Transporter Gateway" }
```

`label: "Transporter Gateway"` - this label will appear in the create menu when adding a new `shipping gateway`.
`type: "frank_martin_shipping_gateway"` - this is the name of the `shipping gateway`.

```php
    // App\EventListener\FrankMartinShippingExportEventListener.php
    //..
    /** @var ShippingExportInterface $shippingExport */
    $shippingExport = $event->getSubject();
    Assert::isInstanceOf($shippingExport, ShippingExportInterface::class);

    $shippingGateway = $shippingExport->getShippingGateway();
    Assert::notNull($shippingGateway);
    // ----------------------------------------------
    $nameOfTheShippingGateway = $shippingGateway->getCode();
    // ----------------------------------------------
```

### Exporting Shipment handling
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

Method responsible for handling the export of the shipment:

`public function exportShipment(ResourceControllerEvent $event): void`

#### Retrieving a parameter from a form

Example with `IBAN` parameter:
```php
// App\Form\Type\FrankMartinShippingGatewayType.php
//..
    ->add('iban', TextType::class, [
        'label' => 'IBAN',
        'constraints' => [
            new NotBlank([
                'message' => 'IBAN number cannot be blank.',
                'groups' => 'bitbag',
            ]),
        ],
    ])
//..
```

Retrieving the `IBAN` parameter from the form when handling `shipment exports`:
```php
// App\EventListener\FrankMartinShippingExportEventListener.php
//..
    /** @var ShippingExportInterface $shippingExport */
    $shippingExport = $event->getSubject();
    Assert::isInstanceOf($shippingExport, ShippingExportInterface::class);

    $shippingGateway = $shippingExport->getShippingGateway();
    Assert::notNull($shippingGateway);

    $parameterIBANFromTheForm = $shippingGateway->getConfigValue('iban');
// ..
```




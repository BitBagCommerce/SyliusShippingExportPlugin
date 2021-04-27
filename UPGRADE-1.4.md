# UPGRADE FROM 1.3 TO 1.4

* The event name `bitbag.export_shipment` has changed to `bitbag.shipping_export.export_shipment` and now is handling by
  EventDispatcher from [SyliusResourceBundle](https://github.com/Sylius/SyliusResourceBundle/blob/master/src/Bundle/Controller/EventDispatcher.php#L39).
  You should register events with Dependency Injection like e.g. 
  ```yaml
  services:
    app.event_listener.frank_martin_shipping_export:
        class: App\EventListener\FrankMartinShippingExportEventListener
        arguments:
            - '@session.flash_bag'
            - '@filesystem'
            - '@bitbag.manager.shipping_export'
            - '%bitbag.shipping_labels_path%'
        tags:
            - { name: kernel.event_listener, event: 'bitbag.shipping_export.export_shipment', method: exportShipment }

  ```
  Then use dependencies inside a method named e.g `exportShipment`
  ```php
    public function __construct(
        FlashBagInterface $flashBag,
        Filesystem $filesystem,
        ObjectManager $shippingExportManager,
        string $shippingLabelsPath
    ) {
        $this->flashBag = $flashBag;
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
        
        #bussines logic here
    }
  ```
* Template `@BitBagSyliusShippingExportPlugin/ShippingExport/Gateways/shippingGateways.html.twig` was removed.
  All FormTypes with `bitbag.shipping_gateway_configuration_type` tag is automatically available in the admin panel
  at the shipping gateway action menu via `AdminShippingGatewayGridEventListener`

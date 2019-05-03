<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusShippingExportPlugin\Event;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\SyliusShippingExportPlugin\Event\ExportShipmentEvent;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

final class ExportShipmentEventSpec extends ObjectBehavior
{
    function let(
        ShippingExportInterface $shippingExport,
        FlashBagInterface $flashBag,
        EntityManagerInterface $shippingExportManager,
        Filesystem $filesystem,
        TranslatorInterface $translator
    ): void {
        $this->beConstructedWith(
            $shippingExport,
            $flashBag,
            $shippingExportManager,
            $filesystem,
            $translator,
            '/shipping_labels'
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ExportShipmentEvent::class);
    }

    function it_extends_event(): void
    {
        $this->shouldHaveType(Event::class);
    }

    function it_returns_shipping_export(ShippingExportInterface $shippingExport): void
    {
        $this->getShippingExport()->shouldReturn($shippingExport);
    }

    function it_adds_success_flash(
        TranslatorInterface $translator,
        FlashBagInterface $flashBag
    ): void {
        $translator
            ->trans('bitbag.ui.shipment_data_has_been_exported')
            ->willReturn('Shipment data has been exported.');
        $flashBag->has('success')->willReturn(false);

        $flashBag
            ->add('success', 'Shipment data has been exported.')
            ->shouldBeCalled();

        $this->addSuccessFlash();
    }

    function it_adds_error_flash(
        TranslatorInterface $translator,
        FlashBagInterface $flashBag
    ): void {
        $translator
            ->trans('bitbag.ui.shipping_export_error')
            ->willReturn('An external error occurred while trying to export shipping data.');
        $flashBag->has('error')->willReturn(false);

        $flashBag
            ->add('error', 'An external error occurred while trying to export shipping data.')
            ->shouldBeCalled();

        $this->addErrorFlash();
    }

    function it_saves_shipping_label(
        ShippingExportInterface $shippingExport,
        ShipmentInterface $shipment,
        OrderInterface $order
    ): void {
        $shippingExport->getShipment()->willReturn($shipment);
        $shipment->getOrder()->willReturn($order);
        $order->getNumber()->willReturn('#0000001');
        $shipment->getId()->willReturn(1);
        $shippingExport->setLabelPath('/shipping_labels/1_0000001.pdf')->shouldBeCalled();

        $this->saveShippingLabel('Length 46 cm x Width 38 cm x Height 89 cm', 'pdf');
    }

    function it_exports_shipment(ShippingExportInterface $shippingExport): void
    {
        /** @var \DateTime $date */
        $date = Argument::type(\DateTime::class);

        $shippingExport->setState(ShippingExportInterface::STATE_EXPORTED)->shouldBeCalled();
        $shippingExport->setExportedAt($date)->shouldBeCalled();

        $this->exportShipment();
    }
}

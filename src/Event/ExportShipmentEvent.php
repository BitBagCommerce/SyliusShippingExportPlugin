<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Event;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

/**
 * @deprecated The ExportShipmentEvent is deprecated since Sylius 1.8 and will be removed. Use \Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent instead
 */
class ExportShipmentEvent extends Event
{
    public const NAME = 'bitbag.shipping_export.export_shipment';

    public const SHORT_NAME = 'export_shipment';

    /** @var ShippingExportInterface */
    private $shippingExport;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var EntityManagerInterface|EntityManager */
    private $shippingExportManager;

    /** @var Filesystem */
    private $filesystem;

    /** @var TranslatorInterface */
    private $translator;

    /** @var string */
    private $shippingLabelsPath;

    public function __construct(
        ShippingExportInterface $shippingExport,
        FlashBagInterface $flashBag,
        EntityManagerInterface $shippingExportManager,
        Filesystem $filesystem,
        TranslatorInterface $translator,
        string $shippingLabelsPath
    ) {
        trigger_deprecation('', '', 'The ExportShipmentEvent is deprecated since Sylius 1.8 and will be removed. Use \Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent instead');
        $this->shippingExport = $shippingExport;
        $this->flashBag = $flashBag;
        $this->shippingExportManager = $shippingExportManager;
        $this->shippingLabelsPath = $shippingLabelsPath;
        $this->filesystem = $filesystem;
        $this->translator = $translator;
    }

    public function getShippingExport(): ?ShippingExportInterface
    {
        return $this->shippingExport;
    }

    public function addSuccessFlash(string $messageId = 'bitbag.ui.shipment_data_has_been_exported'): void
    {
        $message = $this->translator->trans($messageId);

        if (false === $this->flashBag->has('success')) {
            $this->flashBag->add('success', $message);
        }
    }

    public function addErrorFlash(string $messageId = 'bitbag.ui.shipping_export_error'): void
    {
        $message = $this->translator->trans($messageId);

        if (false === $this->flashBag->has('error')) {
            $this->flashBag->add('error', $message);
        }
    }

    public function saveShippingLabel(string $labelContent, string $labelExtension): void
    {
        $labelPath = $this->shippingLabelsPath
            . '/' . $this->getFilename()
            . '.' . $labelExtension;

        $this->filesystem->dumpFile($labelPath, $labelContent);
        $this->shippingExport->setLabelPath($labelPath);

        $this->shippingExportManager->persist($this->shippingExport);
        $this->shippingExportManager->flush();
    }

    public function exportShipment(): void
    {
        $this->shippingExport->setState(ShippingExportInterface::STATE_EXPORTED);
        $this->shippingExport->setExportedAt(new \DateTime());

        $this->shippingExportManager->persist($this->shippingExport);
        $this->shippingExportManager->flush();
    }

    private function getFilename(): string
    {
        $shipment = $this->shippingExport->getShipment();
        Assert::notNull($shipment);
        $order = $shipment->getOrder();
        Assert::notNull($order);
        $orderNumber = $order->getNumber();
        Assert::notNull($orderNumber);
        $shipmentId = $shipment->getId();

        return implode('_', [
            $shipmentId,
            preg_replace('~[^A-Za-z0-9]~', '', $orderNumber),
        ]);
    }
}

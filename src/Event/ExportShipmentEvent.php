<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Event;

use BitBag\ShippingExportPlugin\Entity\ShippingExportInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ExportShipmentEvent extends Event
{
    const NAME = 'bitbag.export_shipment';

    /**
     * @var ShippingExportInterface
     */
    private $shippingExport;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var EntityManagerInterface|EntityManager
     */
    private $shippingExportManager;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $shippingLabelsPath;

    /**
     * @param ShippingExportInterface $shippingExport
     * @param FlashBagInterface $flashBag
     * @param EntityManagerInterface|EntityManager $shippingExportManager
     * @param Filesystem $filesystem
     * @param TranslatorInterface $translator
     * @param string $shippingLabelsPath
     */
    public function __construct(
        ShippingExportInterface $shippingExport,
        FlashBagInterface $flashBag,
        EntityManagerInterface $shippingExportManager,
        Filesystem $filesystem,
        TranslatorInterface $translator,
        $shippingLabelsPath
    )
    {
        $this->shippingExport = $shippingExport;
        $this->flashBag = $flashBag;
        $this->shippingExportManager = $shippingExportManager;
        $this->shippingLabelsPath = $shippingLabelsPath;
        $this->filesystem = $filesystem;
        $this->translator = $translator;
    }

    /**
     * @return ShippingExportInterface
     */
    public function getShippingExport()
    {
        return $this->shippingExport;
    }

    /**
     * @param string $messageId
     */
    public function addSuccessFlash($messageId = 'bitbag.ui.shipment_data_has_been_exported')
    {
        $message = $this->translator->trans($messageId);

        if (false === $this->flashBag->has('success')) {
            $this->flashBag->add('success', $message);
        }
    }

    /**
     * @param string $messageId
     */
    public function addErrorFlash($messageId = 'bitbag.ui.shipping_export_error')
    {
        $message = $this->translator->trans($messageId);

        if (false === $this->flashBag->has('error')) {
            $this->flashBag->add('error', $message);
        }
    }

    /**
     * @param string $labelContent
     * @param string $labelExtension
     */
    public function saveShippingLabel($labelContent, $labelExtension)
    {
        $shipment = $this->getShippingExport()->getShipment();
        $orderNumber = str_replace('#', '', $shipment->getOrder()->getNumber());
        $shipmentId = $shipment->getId();
        $labelPath = $this->shippingLabelsPath
            . '/' . $shipmentId
            . '_' . $orderNumber
            . '.' . $labelExtension
        ;

        $this->filesystem->dumpFile($labelPath, $labelContent);
        $this->shippingExport->setLabelPath($labelPath);
        $this->shippingExportManager->flush($this->shippingExport);
    }

    public function exportShipment()
    {
        $this->shippingExport->setState(ShippingExportInterface::STATE_EXPORTED);
        $this->shippingExport->setExportedAt(new \DateTime());

        $this->shippingExportManager->flush($this->shippingExport);
    }
}
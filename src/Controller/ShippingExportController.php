<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Controller;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\SyliusShippingExportPlugin\Event\ExportShipmentEvent;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmozart\Assert\Assert;

final class ShippingExportController extends ResourceController
{
    public function exportAllNewShipmentsAction(Request $request): RedirectResponse
    {
        $shippingExports = $this->get('bitbag.repository.shipping_export')->findAllWithNewState();

        if (0 === count($shippingExports)) {
            $this->addFlash('error', $this->get('translator')->trans('bitbag.ui.no_new_shipments_to_export'));

            return $this->redirectToReferer($request);
        }

        foreach ($shippingExports as $shippingExport) {
            $this->dispatchExportShipmentEvent($shippingExport);
        }

        return $this->redirectToReferer($request);
    }

    public function exportSingleShipmentAction(Request $request): RedirectResponse
    {
        $shippingExport = $this->get('bitbag.repository.shipping_export')->find($request->get('id'));

        $this->dispatchExportShipmentEvent($shippingExport);

        return $this->redirectToReferer($request);
    }

    private function redirectToReferer(Request $request): RedirectResponse
    {
        return new RedirectResponse($request->headers->get('referer'));
    }

    public function getLabel(Request $request): Response
    {
        $shippingExport = $this->get('bitbag.repository.shipping_export')->find($request->get('id'));

        $labelPath = $shippingExport->getLabelPath();
        Assert::notNull($labelPath);

        $fileSystem = $this->get('filesystem');

        if (false === $fileSystem->exists($labelPath)) {
            throw new NotFoundHttpException();
        }

        $response = new Response(file_get_contents($labelPath));
        $filePathParts = explode('/', $labelPath);
        $labelName = end($filePathParts);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $labelName
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    private function dispatchExportShipmentEvent(ShippingExportInterface $shippingExport): void
    {
        $flashBag = $this->get('session')->getFlashBag();
        $shippingExportManager = $this->get('bitbag.manager.shipping_export');
        $eventDispatcher = $this->get('event_dispatcher');
        $filesystem = $this->get('filesystem');
        $translator = $this->get('translator');
        $shippingLabelsPath = $this->getParameter('bitbag.shipping_labels_path');
        $event = new ExportShipmentEvent(
            $shippingExport,
            $flashBag,
            $shippingExportManager,
            $filesystem,
            $translator,
            $shippingLabelsPath
        );

        $eventDispatcher->dispatch(ExportShipmentEvent::NAME, $event);
    }
}

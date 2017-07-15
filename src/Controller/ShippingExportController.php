<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Controller;

use BitBag\ShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\ShippingExportPlugin\Event\ExportShipmentEvent;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingExportController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function exportAllNewShipmentsAction(Request $request)
    {
        $shippingExports = $this->get('bitbag.repository.shipping_export')->findAllWithNewState();

        if (0 === count($shippingExports)) {
            $this->addFlash('error', $this->get('translator')->trans('bitbag.ui.no_new_shipments_to_export'));

            return $this->redirectToReferer($request);
        }

        foreach ($shippingExports as $shippingExport) {
            $this->dispatchForShippingExport($shippingExport);
        }

        return $this->redirectToReferer($request);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function exportSingleShipmentAction(Request $request)
    {
        $shippingExport = $this->get('bitbag.repository.shipping_export')->find($request->get('id'));

        $this->dispatchForShippingExport($shippingExport);

        return $this->redirectToReferer($request);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    private function redirectToReferer(Request $request)
    {
        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getLabel(Request $request)
    {
        $shippingExport = $this->get('bitbag.repository.shipping_export')->find($request->get('id'));

        $labelPath = $shippingExport->getLabelPath();
        Assert::notNull($labelPath);

        $fs = $this->get('filesystem');

        if (false === $fs->exists($labelPath)) {
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

    /**
     * @param Request $request
     *
     * @throws InvalidCsrfTokenException
     */
    private function checkRequestValidity(Request $request)
    {
        if (false === $this->isCsrfTokenValid('export_shipments_token', $request->get('_token'))) {
            throw new InvalidCsrfTokenException();
        }
    }

    /**
     * @param ShippingExportInterface $shippingExport
     */
    private function dispatchForShippingExport(ShippingExportInterface $shippingExport)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $shippingExportManager = $this->get('bitbag.manager.shipping_export');
        $eventDispatcher = $this->get('event_dispatcher');
        $shippingLabelsPath = $this->getParameter('bitbag.shipping_labels_path');
        $filesystem = $this->get('filesystem');
        $translator = $this->get('translator');
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
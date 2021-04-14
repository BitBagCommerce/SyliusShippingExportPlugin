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

use BitBag\SyliusShippingExportPlugin\Event\ExportShipmentEvent;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmozart\Assert\Assert;

final class ShippingExportController extends ResourceController
{
    /** @var ShippingExportRepositoryInterface */
    protected $repository;

    public function exportAllNewShipmentsAction(Request $request): RedirectResponse
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $shippingExports = $this->repository->findAllWithNewState();

        if (0 === count($shippingExports)) {
            $this->addFlash('error', 'bitbag.ui.no_new_shipments_to_export');

            return $this->redirectToReferer($request);
        }

        foreach ($shippingExports as $shippingExport) {
            $this->eventDispatcher->dispatch(
                ExportShipmentEvent::SHORT_NAME,
                $configuration,
                $shippingExport
            );
        }

        return $this->redirectToReferer($request);
    }

    public function exportSingleShipmentAction(Request $request): RedirectResponse
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $shippingExport = $this->repository->find($request->get('id'));
        Assert::notNull($shippingExport);

        $this->eventDispatcher->dispatch(
            ExportShipmentEvent::SHORT_NAME,
            $configuration,
            $shippingExport
        );

        return $this->redirectToReferer($request);
    }

    private function redirectToReferer(Request $request): RedirectResponse
    {
        return new RedirectResponse($request->headers->get('referer'));
    }

    public function getLabel(Request $request): Response
    {
        $shippingExport = $this->repository->find($request->get('id'));
        Assert::notNull($shippingExport);

        $labelPath = $shippingExport->getLabelPath();
        Assert::notNull($labelPath);

        $fileSystem = $this->get('filesystem');

        if (false === $fileSystem->exists($labelPath)) {
            throw new NotFoundHttpException();
        }

        $response = new Response(file_get_contents($labelPath));
        $filePathParts = explode(DIRECTORY_SEPARATOR, $labelPath);
        $labelName = end($filePathParts);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $labelName
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}

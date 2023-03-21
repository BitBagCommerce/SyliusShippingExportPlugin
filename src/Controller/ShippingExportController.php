<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Controller;

use BitBag\SyliusShippingExportPlugin\Event\ExportShipmentEvent;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class ShippingExportController extends ResourceController
{
    public function exportAllNewShipmentsAction(Request $request): RedirectResponse
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        Assert::implementsInterface($this->repository, ShippingExportRepositoryInterface::class);
        $shippingExports = $this->repository->findAllWithNewOrPendingState();

        if (0 === count($shippingExports)) {
            $request->getSession()->getBag('flashes')->add('error', 'bitbag.ui.no_new_shipments_to_export');

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

        /** @var ResourceInterface|null $shippingExport */
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
        $referer = $request->headers->get('referer');
        if (null !== $referer) {
            return new RedirectResponse($referer);
        }

        return $this->redirectToRoute($request->attributes->get('_route'));
    }
}

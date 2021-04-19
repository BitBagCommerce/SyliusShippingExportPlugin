<?php

namespace spec\BitBag\SyliusShippingExportPlugin\Controller;

use BitBag\SyliusShippingExportPlugin\Controller\ShippingExportDownloadLabelAction;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingExportInterface;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingExportRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShippingExportDownloadLabelActionSpec extends ObjectBehavior
{
    function let(
        Filesystem $filesystem,
        ShippingExportRepositoryInterface $repository
    ): void {
        $this->beConstructedWith(
            $filesystem,
            $repository,
            '/var/www/shipping_labels'
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShippingExportDownloadLabelAction::class);
    }

    function it_should_not_allow_directory_travelsal(
        Request $request,
        ShippingExportRepositoryInterface $repository,
        ShippingExportInterface $shippingExport
    ): void {
        $request->get('id')->willReturn(1);
        $shippingExport->getLabelPath()
            ->willReturn('/var/www/shipping_labels/../.env');
        $repository->find(1)->willReturn($shippingExport);

        $this->shouldThrow(NotFoundHttpException::class)
            ->during('__invoke', [$request]);
    }

    function it_returns_a_streamed_response_for_label(
        Request $request,
        ShippingExportRepositoryInterface $repository,
        ShippingExportInterface $shippingExport
    ): void {
        $request->get('id')
            ->willReturn(1);
        $shippingExport->getLabelPath()
            ->willReturn('/var/www/shipping_labels/label.pdf');
        $repository->find(1)
            ->willReturn($shippingExport);

        $this->__invoke($request)
            ->shouldBeAnInstanceOf(StreamedResponse::class);
        $this->__invoke($request)
            ->headers->get('Content-Disposition')
            ->shouldReturn('attachment; filename=label.pdf');
    }
}
